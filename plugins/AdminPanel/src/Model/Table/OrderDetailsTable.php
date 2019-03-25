<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderDetails Model
 *
 * @property \AdminPanel\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 * @property \AdminPanel\Model\Table\BranchesTable|\Cake\ORM\Association\BelongsTo $Branches
 * @property \AdminPanel\Model\Table\CourriersTable|\Cake\ORM\Association\BelongsTo $Courriers
 * @property \AdminPanel\Model\Table\ProvincesTable|\Cake\ORM\Association\BelongsTo $Provinces
 * @property \AdminPanel\Model\Table\CitiesTable|\Cake\ORM\Association\BelongsTo $Cities
 * @property \AdminPanel\Model\Table\SubdistrictsTable|\Cake\ORM\Association\BelongsTo $Subdistricts
 * @property \AdminPanel\Model\Table\OrderStatusesTable|\Cake\ORM\Association\BelongsTo $OrderStatuses
 * @property \AdminPanel\Model\Table\ChatsTable|\Cake\ORM\Association\HasMany $Chats
 * @property \AdminPanel\Model\Table\OrderDetailProductsTable|\Cake\ORM\Association\HasMany $OrderDetailProducts
 * @property \AdminPanel\Model\Table\OrderShippingDetailsTable|\Cake\ORM\Association\HasMany $OrderShippingDetails
 *
 * @method \AdminPanel\Model\Entity\OrderDetail get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetail newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetail[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetail|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetail findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderDetailsTable extends Table
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

        $this->setTable('order_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'className' => 'AdminPanel.Orders'
        ]);
        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'className' => 'AdminPanel.Branches'
        ]);
        $this->belongsTo('Courriers', [
            'foreignKey' => 'courrier_id',
            'className' => 'AdminPanel.Courriers'
        ]);
        $this->belongsTo('Provinces', [
            'foreignKey' => 'province_id',
            'className' => 'AdminPanel.Provinces'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id',
            'className' => 'AdminPanel.Cities'
        ]);
        $this->belongsTo('Subdistricts', [
            'foreignKey' => 'subdistrict_id',
            'className' => 'AdminPanel.Subdistricts'
        ]);
        $this->belongsTo('OrderStatuses', [
            'foreignKey' => 'order_status_id',
            'className' => 'AdminPanel.OrderStatuses'
        ]);
        $this->hasMany('Chats', [
            'foreignKey' => 'order_detail_id',
            'className' => 'AdminPanel.Chats'
        ]);
        $this->hasMany('OrderDetailProducts', [
            'foreignKey' => 'order_detail_id',
            'className' => 'AdminPanel.OrderDetailProducts'
        ]);
        $this->hasMany('OrderShippingDetails', [
            'foreignKey' => 'order_detail_id',
            'className' => 'AdminPanel.OrderShippingDetails'
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
            ->scalar('awb')
            ->maxLength('awb', 50)
            ->allowEmptyString('awb');

        $validator
            ->numeric('product_price')
            ->allowEmptyString('product_price');

        $validator
            ->scalar('shipping_code')
            ->maxLength('shipping_code', 10)
            ->allowEmptyString('shipping_code');

        $validator
            ->scalar('shipping_service')
            ->maxLength('shipping_service', 10)
            ->allowEmptyString('shipping_service');

        $validator
            ->integer('shipping_weight')
            ->allowEmptyString('shipping_weight');

        $validator
            ->numeric('shipping_cost')
            ->allowEmptyString('shipping_cost');

        $validator
            ->numeric('total')
            ->allowEmptyString('total');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));
        $rules->add($rules->existsIn(['branch_id'], 'Branches'));
        $rules->add($rules->existsIn(['courrier_id'], 'Courriers'));
        $rules->add($rules->existsIn(['province_id'], 'Provinces'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['subdistrict_id'], 'Subdistricts'));
        $rules->add($rules->existsIn(['order_status_id'], 'OrderStatuses'));

        return $rules;
    }
}
