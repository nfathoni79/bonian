<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OptionValues Model
 *
 * @property \AdminPanel\Model\Table\OptionsTable|\Cake\ORM\Association\BelongsTo $Options
 * @property \AdminPanel\Model\Table\ProductOptionValuesTable|\Cake\ORM\Association\HasMany $ProductOptionValues
 *
 * @method \AdminPanel\Model\Entity\OptionValue get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue findOrCreate($search, callable $callback = null, $options = [])
 */
class OptionValuesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('option_values');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Options', [
            'foreignKey' => 'option_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Options'
        ]);
        $this->hasMany('ProductOptionValues', [
            'foreignKey' => 'option_value_id',
            'className' => 'AdminPanel.ProductOptionValues'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['option_id'], 'Options'));

        return $rules;
    }
}
