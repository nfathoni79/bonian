<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Provinces Model
 *
 * @property \AdminPanel\Model\Table\CustomerAddressesTable|\Cake\ORM\Association\HasMany $CustomerAddresses
 * @property \AdminPanel\Model\Table\RegenciesTable|\Cake\ORM\Association\HasMany $Regencies
 *
 * @method \AdminPanel\Model\Entity\Province get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\Province newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\Province[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Province|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Province|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Province patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Province[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Province findOrCreate($search, callable $callback = null, $options = [])
 */
class ProvincesTable extends Table
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

        $this->setTable('provinces');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('CustomerAddresses', [
            'foreignKey' => 'province_id',
            'className' => 'AdminPanel.CustomerAddresses'
        ]);
        $this->hasMany('Regencies', [
            'foreignKey' => 'province_id',
            'className' => 'AdminPanel.Regencies'
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
}
