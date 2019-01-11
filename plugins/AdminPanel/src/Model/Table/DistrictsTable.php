<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Districts Model
 *
 * @property \AdminPanel\Model\Table\RegenciesTable|\Cake\ORM\Association\BelongsTo $Regencies
 * @property \AdminPanel\Model\Table\CustomerAddressesTable|\Cake\ORM\Association\HasMany $CustomerAddresses
 * @property \AdminPanel\Model\Table\VillagesTable|\Cake\ORM\Association\HasMany $Villages
 *
 * @method \AdminPanel\Model\Entity\District get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\District newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\District[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\District|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\District|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\District patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\District[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\District findOrCreate($search, callable $callback = null, $options = [])
 */
class DistrictsTable extends Table
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

        $this->setTable('districts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Regencies', [
            'foreignKey' => 'regency_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Regencies'
        ]);
        $this->hasMany('CustomerAddresses', [
            'foreignKey' => 'district_id',
            'className' => 'AdminPanel.CustomerAddresses'
        ]);
        $this->hasMany('Villages', [
            'foreignKey' => 'district_id',
            'className' => 'AdminPanel.Villages'
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
        $rules->add($rules->existsIn(['regency_id'], 'Regencies'));

        return $rules;
    }
}
