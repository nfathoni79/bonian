<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Branches Model
 *
 * @property \AdminPanel\Model\Table\ProvincesTable|\Cake\ORM\Association\BelongsTo $Provinces
 * @property \AdminPanel\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \AdminPanel\Model\Table\SubdistrictsTable|\Cake\ORM\Association\BelongsTo $Subdistricts
 * @property \AdminPanel\Model\Table\OrderDetailsTable|\Cake\ORM\Association\HasMany $OrderDetails
 * @property \AdminPanel\Model\Table\ProductBranchesTable|\Cake\ORM\Association\HasMany $ProductBranches
 * @property \AdminPanel\Model\Table\ProductOptionValuesTable|\Cake\ORM\Association\HasMany $ProductOptionValues
 * @property \AdminPanel\Model\Table\ProductStockMutationsTable|\Cake\ORM\Association\HasMany $ProductStockMutations
 * @property \AdminPanel\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 *
 * @method \AdminPanel\Model\Entity\Branch get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\Branch newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\Branch[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Branch|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Branch|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Branch patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Branch[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Branch findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BranchesTable extends Table
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

        $this->setTable('branches');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Provinces', [
            'foreignKey' => 'provice_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Provinces'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Cities'
        ]);
        $this->belongsTo('Subdistricts', [
            'foreignKey' => 'subdistrict_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Subdistricts'
        ]);
        $this->hasMany('OrderDetails', [
            'foreignKey' => 'branch_id',
            'className' => 'AdminPanel.OrderDetails'
        ]);
        $this->hasMany('ProductBranches', [
            'foreignKey' => 'branch_id',
            'className' => 'AdminPanel.ProductBranches'
        ]);
        $this->hasMany('ProductOptionValues', [
            'foreignKey' => 'branch_id',
            'className' => 'AdminPanel.ProductOptionValues'
        ]);
        $this->hasMany('ProductStockMutations', [
            'foreignKey' => 'branch_id',
            'className' => 'AdminPanel.ProductStockMutations'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'branch_id',
            'className' => 'AdminPanel.Users'
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
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('address')
            ->requirePresence('address', 'create')
            ->allowEmptyString('address', false);

        $validator
            ->scalar('phone')
            ->maxLength('phone', 15)
            ->requirePresence('phone', 'create')
            ->allowEmptyString('phone', false);

        $validator
            ->numeric('latitude')
            ->requirePresence('latitude', 'create')
            ->allowEmptyString('latitude', false);

        $validator
            ->numeric('longitude')
            ->requirePresence('longitude', 'create')
            ->allowEmptyString('longitude', false);

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
        $rules->add($rules->existsIn(['provice_id'], 'Provinces'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['subdistrict_id'], 'Subdistricts'));

        return $rules;
    }
}
