<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductOptionStocks Model
 *
 * @property \AdminPanel\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \AdminPanel\Model\Table\ProductOptionPricesTable|\Cake\ORM\Association\BelongsTo $ProductOptionPrices
 * @property \AdminPanel\Model\Table\BranchesTable|\Cake\ORM\Association\BelongsTo $Branches
 * @property \AdminPanel\Model\Table\ProductStockMutationsTable|\Cake\ORM\Association\HasMany $ProductStockMutations
 *
 * @method \AdminPanel\Model\Entity\ProductOptionStock get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionStock newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionStock[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionStock|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionStock|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionStock patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionStock[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionStock findOrCreate($search, callable $callback = null, $options = [])
 */
class ProductOptionStocksTable extends Table
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

        $this->setTable('product_option_stocks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'className' => 'AdminPanel.Products'
        ]);
        $this->belongsTo('ProductOptionPrices', [
            'foreignKey' => 'product_option_price_id',
            'className' => 'AdminPanel.ProductOptionPrices'
        ]);
        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'className' => 'AdminPanel.Branches'
        ]);
        $this->hasMany('ProductStockMutations', [
            'foreignKey' => 'product_option_stock_id',
            'className' => 'AdminPanel.ProductStockMutations'
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
            ->integer('weight')
            ->allowEmptyString('weight');

        $validator
            ->integer('stock')
            ->allowEmptyString('stock');

        $validator
            ->integer('width')
            ->allowEmptyString('width');

        $validator
            ->integer('length')
            ->allowEmptyString('length');

        $validator
            ->integer('height')
            ->allowEmptyString('height');

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
        $rules->add($rules->existsIn(['product_option_price_id'], 'ProductOptionPrices'));
        $rules->add($rules->existsIn(['branch_id'], 'Branches'));

        return $rules;
    }
}
