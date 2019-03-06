<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Brands Model
 *
 * @property \AdminPanel\Model\Table\ProductCategoriesTable|\Cake\ORM\Association\BelongsTo $ProductCategories
 * @property \AdminPanel\Model\Table\BrandsTable|\Cake\ORM\Association\BelongsTo $ParentBrands
 * @property \AdminPanel\Model\Table\BrandsTable|\Cake\ORM\Association\HasMany $ChildBrands
 * @property \AdminPanel\Model\Table\ProductsTable|\Cake\ORM\Association\HasMany $Products
 *
 * @method \AdminPanel\Model\Entity\Brand get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\Brand newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\Brand[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Brand|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Brand|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Brand patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Brand[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Brand findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class BrandsTable extends Table
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

        $this->setTable('brands');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Tree');

        $this->addBehavior('Elastic/ActivityLogger.Logger', [
            'scope' => [
                'Brands'
            ],
            'issuer' => \Cake\Core\Configure::read('User') ?
                \Cake\ORM\TableRegistry::get('AdminPanel.Users')->get(\Cake\Core\Configure::read('User.id'))
                : null
        ]);


        $this->belongsTo('ProductCategories', [
            'foreignKey' => 'product_category_id',
            'className' => 'AdminPanel.ProductCategories'
        ]);
        $this->belongsTo('ParentBrands', [
            'className' => 'AdminPanel.Brands',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildBrands', [
            'className' => 'AdminPanel.Brands',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Products', [
            'foreignKey' => 'brand_id',
            'className' => 'AdminPanel.Products'
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
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

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
        $rules->add($rules->existsIn(['product_category_id'], 'ProductCategories'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentBrands'));

        return $rules;
    }
}
