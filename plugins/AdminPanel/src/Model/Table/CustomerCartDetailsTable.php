<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerCartDetails Model
 *
 * @property \ADminPanel\Model\Table\CustomerCartsTable|\Cake\ORM\Association\BelongsTo $CustomerCarts
 * @property \AdminPanel\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \AdminPanel\Model\Table\ProductOptionPricesTable|\Cake\ORM\Association\BelongsTo $ProductOptionPrices
 * @property \AdminPanel\Model\Table\ProductOptionStocksTable|\Cake\ORM\Association\BelongsTo $ProductOptionStocks
 *
 * @method \AdminPanel\Model\Entity\CustomerCartDetail get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCartDetail newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCartDetail[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCartDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCartDetail|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCartDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCartDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCartDetail findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomerCartDetailsTable extends Table
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

        $this->setTable('customer_cart_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CustomerCarts', [
            'foreignKey' => 'customer_cart_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.CustomerCarts'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Products'
        ]);
        $this->belongsTo('ProductOptionPrices', [
            'foreignKey' => 'product_option_price_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.ProductOptionPrices'
        ]);
        $this->belongsTo('ProductOptionStocks', [
            'foreignKey' => 'product_option_stock_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.ProductOptionStocks'
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
            ->integer('qty')
            ->requirePresence('qty', 'create')
            ->allowEmptyString('qty', false);

        $validator
            ->numeric('price')
            ->requirePresence('price', 'create')
            ->allowEmptyString('price', false);

        $validator
            ->numeric('point')
            ->requirePresence('point', 'create')
            ->allowEmptyString('point', false);

        $validator
            ->numeric('add_price')
            ->requirePresence('add_price', 'create')
            ->allowEmptyString('add_price', false);

        $validator
            ->boolean('in_flashsale')
            ->requirePresence('in_flashsale', 'create')
            ->allowEmptyString('in_flashsale', false);

        $validator
            ->boolean('in_groupsale')
            ->requirePresence('in_groupsale', 'create')
            ->allowEmptyString('in_groupsale', false);

        $validator
            ->numeric('total')
            ->requirePresence('total', 'create')
            ->allowEmptyString('total', false);

        $validator
            ->numeric('totalpoint')
            ->requirePresence('totalpoint', 'create')
            ->allowEmptyString('totalpoint', false);

        $validator
            ->scalar('comment')
            ->allowEmptyString('comment');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->allowEmptyString('status', false);

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
        $rules->add($rules->existsIn(['customer_cart_id'], 'CustomerCarts'));
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['product_option_price_id'], 'ProductOptionPrices'));
        $rules->add($rules->existsIn(['product_option_stock_id'], 'ProductOptionStocks'));

        return $rules;
    }
}
