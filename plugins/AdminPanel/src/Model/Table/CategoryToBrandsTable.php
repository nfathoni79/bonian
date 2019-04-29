<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CategoryToBrands Model
 *
 * @property \AdminPanel\Model\Table\ProductCategoriesTable|\Cake\ORM\Association\BelongsTo $ProductCategories
 * @property \AdminPanel\Model\Table\BrandsTable|\Cake\ORM\Association\BelongsTo $Brands
 *
 * @method \AdminPanel\Model\Entity\CategoryToBrand get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\CategoryToBrand newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\CategoryToBrand[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CategoryToBrand|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\CategoryToBrand|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\CategoryToBrand patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CategoryToBrand[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CategoryToBrand findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CategoryToBrandsTable extends Table
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

        $this->setTable('category_to_brands');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProductCategories', [
            'foreignKey' => 'product_category_id',
            'className' => 'AdminPanel.ProductCategories'
        ]);
        $this->belongsTo('Brands', [
            'foreignKey' => 'brand_id',
            'className' => 'AdminPanel.Brands'
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
        $rules->add($rules->existsIn(['brand_id'], 'Brands'));
        $rules->add($rules->isUnique(['brand_id', 'product_category_id'], 'Brand sudah terdaftar.'));

        return $rules;
    }
}
