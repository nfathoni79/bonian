<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderDetailProducts Model
 *
 * @property \AdminPanel\Model\Table\OrderDetailsTable|\Cake\ORM\Association\BelongsTo $OrderDetails
 * @property \AdminPanel\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \AdminPanel\Model\Table\OptionValuesTable|\Cake\ORM\Association\BelongsTo $OptionValues
 * @property \AdminPanel\Model\Table\ProductOptionPricesTable|\Cake\ORM\Association\BelongsTo $ProductOptionPrices
 * @property \AdminPanel\Model\Table\ProductOptionStocksTable|\Cake\ORM\Association\BelongsTo $ProductOptionStocks
 * @property \AdminPanel\Model\Table\ProductRatingsTable|\Cake\ORM\Association\HasMany $ProductRatings
 *
 * @method \AdminPanel\Model\Entity\OrderDetailProduct get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetailProduct newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetailProduct[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetailProduct|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetailProduct|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetailProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetailProduct[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OrderDetailProduct findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderDetailProductsTable extends Table
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

        $this->setTable('order_detail_products');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OrderDetails', [
            'foreignKey' => 'order_detail_id',
            'className' => 'AdminPanel.OrderDetails'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'className' => 'AdminPanel.Products'
        ]);
        $this->belongsTo('OptionValues', [
            'foreignKey' => 'product_option_value_id',
            'className' => 'AdminPanel.OptionValues'
        ]);
        $this->belongsTo('ProductOptionPrices', [
            'foreignKey' => 'product_option_price_id',
            'className' => 'AdminPanel.ProductOptionPrices'
        ]);
        $this->belongsTo('ProductOptionStocks', [
            'foreignKey' => 'product_option_stock_id',
            'className' => 'AdminPanel.ProductOptionStocks'
        ]);
        $this->hasMany('ProductRatings', [
            'foreignKey' => 'order_detail_product_id',
            'className' => 'AdminPanel.ProductRatings'
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
            ->allowEmptyString('qty');

        $validator
            ->numeric('price')
            ->allowEmptyString('price');

        $validator
            ->numeric('total')
            ->allowEmptyString('total');

        $validator
            ->scalar('comment')
            ->maxLength('comment', 255)
            ->allowEmptyString('comment');

        $validator
            ->boolean('in_flashsale')
            ->requirePresence('in_flashsale', 'create')
            ->allowEmptyString('in_flashsale', false);

        $validator
            ->boolean('in_groupsale')
            ->requirePresence('in_groupsale', 'create')
            ->allowEmptyString('in_groupsale', false);

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
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['product_option_value_id'], 'OptionValues'));
        $rules->add($rules->existsIn(['product_option_price_id'], 'ProductOptionPrices'));
        $rules->add($rules->existsIn(['product_option_stock_id'], 'ProductOptionStocks'));

        return $rules;
    }
}
