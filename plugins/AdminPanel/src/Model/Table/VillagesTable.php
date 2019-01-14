<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Villages Model
 *
 * @property \AdminPanel\Model\Table\DistrictsTable|\Cake\ORM\Association\BelongsTo $Districts
 * @property \AdminPanel\Model\Table\CustomerAddressesTable|\Cake\ORM\Association\HasMany $CustomerAddresses
 *
 * @method \AdminPanel\Model\Entity\Village get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\Village newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\Village[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Village|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Village|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Village patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Village[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Village findOrCreate($search, callable $callback = null, $options = [])
 */
class VillagesTable extends Table
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

        $this->setTable('villages');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Districts', [
            'foreignKey' => 'district_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Districts'
        ]);
        $this->hasMany('CustomerAddresses', [
            'foreignKey' => 'village_id',
            'className' => 'AdminPanel.CustomerAddresses'
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
            ->maxLength('name', 255)
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
        $rules->add($rules->existsIn(['district_id'], 'Districts'));

        return $rules;
    }
}
