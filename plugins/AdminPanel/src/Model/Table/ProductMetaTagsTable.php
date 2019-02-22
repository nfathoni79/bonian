<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductMetaTags Model
 *
 * @property \AdminPanel\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \AdminPanel\Model\Entity\ProductMetaTag get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ProductMetaTag newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductMetaTag[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductMetaTag|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductMetaTag|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductMetaTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductMetaTag[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductMetaTag findOrCreate($search, callable $callback = null, $options = [])
 */
class ProductMetaTagsTable extends Table
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

        $this->setTable('product_meta_tags');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
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
            ->scalar('keyword')
            ->maxLength('keyword', 255)
            ->requirePresence('keyword', 'create')
            ->allowEmptyString('keyword', false);

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->allowEmptyString('description', false);

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

        return $rules;
    }
}
