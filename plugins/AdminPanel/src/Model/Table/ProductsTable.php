<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \AdminPanel\Model\Table\ProductStockStatusesTable|\Cake\ORM\Association\BelongsTo $ProductStockStatuses
 * @property \AdminPanel\Model\Table\ProductWeightClassesTable|\Cake\ORM\Association\BelongsTo $ProductWeightClasses
 * @property \AdminPanel\Model\Table\ProductStatusesTable|\Cake\ORM\Association\BelongsTo $ProductStatuses
 * @property \AdminPanel\Model\Table\OrderProductsTable|\Cake\ORM\Association\HasMany $OrderProducts
 * @property \AdminPanel\Model\Table\ProductAttributesTable|\Cake\ORM\Association\HasMany $ProductAttributes
 * @property \AdminPanel\Model\Table\ProductDealsTable|\Cake\ORM\Association\HasMany $ProductDeals
 * @property \AdminPanel\Model\Table\ProductDiscountsTable|\Cake\ORM\Association\HasMany $ProductDiscounts
 * @property \AdminPanel\Model\Table\ProductImagesTable|\Cake\ORM\Association\HasMany $ProductImages
 * @property \AdminPanel\Model\Table\ProductMetaTagsTable|\Cake\ORM\Association\HasMany $ProductMetaTags
 * @property \AdminPanel\Model\Table\ProductOptionValuesTable|\Cake\ORM\Association\HasMany $ProductOptionValues
 * @property \AdminPanel\Model\Table\ProductStockMutationsTable|\Cake\ORM\Association\HasMany $ProductStockMutations
 * @property \AdminPanel\Model\Table\ProductToCategoriesTable|\Cake\ORM\Association\HasMany $ProductToCategories
 *
 * @method \AdminPanel\Model\Entity\Product get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Product|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Product|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Product findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends Table
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

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProductStockStatuses', [
            'foreignKey' => 'product_stock_status_id',
            'className' => 'AdminPanel.ProductStockStatuses'
        ]);
        $this->belongsTo('ProductWeightClasses', [
            'foreignKey' => 'product_weight_class_id',
            'className' => 'AdminPanel.ProductWeightClasses'
        ]);
        $this->belongsTo('ProductStatuses', [
            'foreignKey' => 'product_status_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.ProductStatuses'
        ]);
        $this->hasMany('OrderProducts', [
            'foreignKey' => 'product_id',
            'className' => 'AdminPanel.OrderProducts'
        ]);
        $this->hasMany('ProductAttributes', [
            'foreignKey' => 'product_id',
            'className' => 'AdminPanel.ProductAttributes'
        ]);
        $this->hasMany('ProductDeals', [
            'foreignKey' => 'product_id',
            'className' => 'AdminPanel.ProductDeals'
        ]);
        $this->hasMany('ProductDiscounts', [
            'foreignKey' => 'product_id',
            'className' => 'AdminPanel.ProductDiscounts'
        ]);
        $this->hasMany('ProductImages', [
            'foreignKey' => 'product_id',
            'className' => 'AdminPanel.ProductImages'
        ]);
        $this->hasMany('ProductMetaTags', [
            'foreignKey' => 'product_id',
            'className' => 'AdminPanel.ProductMetaTags'
        ]);
        $this->hasMany('ProductOptionValues', [
            'foreignKey' => 'product_id',
            'className' => 'AdminPanel.ProductOptionValues'
        ]);
        $this->hasMany('ProductStockMutations', [
            'foreignKey' => 'product_id',
            'className' => 'AdminPanel.ProductStockMutations'
        ]);
        $this->hasMany('ProductToCategories', [
            'foreignKey' => 'product_id',
            'className' => 'AdminPanel.ProductToCategories'
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

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->allowEmptyString('slug');

        $validator
            ->scalar('model')
            ->maxLength('model', 100)
            ->allowEmptyString('model');

        $validator
            ->scalar('code')
            ->maxLength('code', 50)
            ->allowEmptyString('code');

        $validator
            ->scalar('sku')
            ->maxLength('sku', 25)
            ->allowEmptyString('sku');

        $validator
            ->scalar('isbn')
            ->maxLength('isbn', 25)
            ->allowEmptyString('isbn');

        $validator
            ->integer('qty')
            ->requirePresence('qty', 'create')
            ->allowEmptyString('qty', false);

        $validator
            ->integer('shipping')
            ->requirePresence('shipping', 'create')
            ->allowEmptyString('shipping', false);

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->allowEmptyString('price', false);

        $validator
            ->decimal('price_discount')
            ->requirePresence('price_discount', 'create')
            ->allowEmptyString('price_discount', false);

        $validator
            ->numeric('weight')
            ->allowEmptyString('weight');

        $validator
            ->scalar('highlight')
            ->allowEmptyString('highlight');

        $validator
            ->scalar('condition')
            ->allowEmptyString('condition');

        $validator
            ->scalar('profile')
            ->allowEmptyFile('profile');

        $validator
            ->integer('view')
            ->requirePresence('view', 'create')
            ->allowEmptyString('view', false);

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
        $rules->add($rules->existsIn(['product_stock_status_id'], 'ProductStockStatuses'));
        $rules->add($rules->existsIn(['product_weight_class_id'], 'ProductWeightClasses'));
        $rules->add($rules->existsIn(['product_status_id'], 'ProductStatuses'));

        return $rules;
    }
}
