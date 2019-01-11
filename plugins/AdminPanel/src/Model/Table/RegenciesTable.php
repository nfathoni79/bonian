<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Regencies Model
 *
 * @property \AdminPanel\Model\Table\ProvincesTable|\Cake\ORM\Association\BelongsTo $Provinces
 * @property \AdminPanel\Model\Table\CustomerAddressesTable|\Cake\ORM\Association\HasMany $CustomerAddresses
 * @property \AdminPanel\Model\Table\DistrictsTable|\Cake\ORM\Association\HasMany $Districts
 *
 * @method \AdminPanel\Model\Entity\Regency get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\Regency newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\Regency[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Regency|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Regency|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Regency patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Regency[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Regency findOrCreate($search, callable $callback = null, $options = [])
 */
class RegenciesTable extends Table
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

        $this->setTable('regencies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Provinces', [
            'foreignKey' => 'province_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Provinces'
        ]);
        $this->hasMany('CustomerAddresses', [
            'foreignKey' => 'regency_id',
            'className' => 'AdminPanel.CustomerAddresses'
        ]);
        $this->hasMany('Districts', [
            'foreignKey' => 'regency_id',
            'className' => 'AdminPanel.Districts'
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
        $rules->add($rules->existsIn(['province_id'], 'Provinces'));

        return $rules;
    }
}
