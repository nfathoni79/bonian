<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductPromotions Model
 *
 * @property \AdminPanel\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \AdminPanel\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \AdminPanel\Model\Table\OrdersTable|\Cake\ORM\Association\HasMany $Orders
 * @property \AdminPanel\Model\Table\ProductPromotionImagesTable|\Cake\ORM\Association\HasMany $ProductPromotionImages
 *
 * @method \AdminPanel\Model\Entity\ProductPromotion get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ProductPromotion newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductPromotion[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductPromotion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductPromotion|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductPromotion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductPromotion[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductPromotion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductPromotionsTable extends Table
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

        $this->setTable('product_promotions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Products'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'free_product_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Products'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'product_promotion_id',
            'className' => 'AdminPanel.Orders'
        ]);
        $this->hasMany('ProductPromotionImages', [
            'foreignKey' => 'product_promotion_id',
            'className' => 'AdminPanel.ProductPromotionImages'
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
            ->integer('qty')
            ->requirePresence('qty', 'create')
            ->allowEmptyString('qty', false);

        $validator
            ->integer('min_qty')
            ->requirePresence('min_qty', 'create')
            ->allowEmptyString('min_qty', false);

        $validator
            ->integer('free_qty')
            ->requirePresence('free_qty', 'create')
            ->allowEmptyString('free_qty', false);

        $validator
            ->dateTime('date_start')
            ->requirePresence('date_start', 'create')
            ->allowEmptyDateTime('date_start', false);

        $validator
            ->dateTime('date_end')
            ->requirePresence('date_end', 'create')
            ->allowEmptyDateTime('date_end', false);

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
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['free_product_id'], 'Products'));

        return $rules;
    }
}
