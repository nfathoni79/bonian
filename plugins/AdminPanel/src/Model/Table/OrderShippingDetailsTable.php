<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderShippingDetails Model
 *
 * @property \AdminPanel\Model\Table\OrderDetailsTable|\Cake\ORM\Association\BelongsTo $OrderDetails
 *
 * @method \AdminPanel\Model\Entity\OrderShippingDetail get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\OrderShippingDetail newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderShippingDetail[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderShippingDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\OrderShippingDetail|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\OrderShippingDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderShippingDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderShippingDetail findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderShippingDetailsTable extends Table
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

        $this->setTable('order_shipping_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OrderDetails', [
            'foreignKey' => 'order_detail_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.OrderDetails'
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
            ->integer('status')
            ->requirePresence('status', 'create')
            ->allowEmptyString('status', false);

        $validator
            ->scalar('note')
            ->requirePresence('note', 'create')
            ->allowEmptyString('note', false);

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
        $rules->add($rules->existsIn(['order_detail_id'], 'OrderDetails'));

        return $rules;
    }
}
