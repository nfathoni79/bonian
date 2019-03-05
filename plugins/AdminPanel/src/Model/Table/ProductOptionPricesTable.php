<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductOptionPrices Model
 *
 * @property \AdminPanel\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \AdminPanel\Model\Table\ProductOptionStocksTable|\Cake\ORM\Association\HasMany $ProductOptionStocks
 * @property \AdminPanel\Model\Table\ProductOptionValueListsTable|\Cake\ORM\Association\HasMany $ProductOptionValueLists
 *
 * @method \AdminPanel\Model\Entity\ProductOptionPrice get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionPrice newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionPrice[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionPrice|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionPrice|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionPrice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionPrice[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductOptionPrice findOrCreate($search, callable $callback = null, $options = [])
 */
class ProductOptionPricesTable extends Table
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

        $this->setTable('product_option_prices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');


        $this->addBehavior('Elastic/ActivityLogger.Logger', [
            'scope' => [
                'ProductOptionPrices'
            ],
            'issuer' => \Cake\Core\Configure::read('User') ?
                \Cake\ORM\TableRegistry::get('AdminPanel.Users')->get(\Cake\Core\Configure::read('User.id'))
                : null
        ]);


        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Products'
        ]);
        $this->hasMany('ProductOptionStocks', [
            'foreignKey' => 'product_option_price_id',
            'className' => 'AdminPanel.ProductOptionStocks'
        ]);
        $this->hasMany('ProductOptionValueLists', [
            'foreignKey' => 'product_option_price_id',
            'className' => 'AdminPanel.ProductOptionValueLists'
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
            ->numeric('price')
            ->requirePresence('price', 'create')
            ->allowEmptyString('price', false);

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
        $rules->add($rules->isUnique(['sku']));

        return $rules;
    }
}
