<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SearchCategories Model
 *
 * @property \AdminPanel\Model\Table\SearchTermsTable|\Cake\ORM\Association\BelongsTo $SearchTerms
 * @property \AdminPanel\Model\Table\ProductCategoriesTable|\Cake\ORM\Association\BelongsTo $ProductCategories
 * @property \AdminPanel\Model\Table\BrowsersTable|\Cake\ORM\Association\BelongsTo $Browsers
 *
 * @method \AdminPanel\Model\Entity\SearchCategory get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\SearchCategory newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchCategory[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\SearchCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\SearchCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SearchCategoriesTable extends Table
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

        $this->setTable('search_categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('SearchTerms', [
            'foreignKey' => 'search_term_id',
            'className' => 'AdminPanel.SearchTerms'
        ]);
        $this->belongsTo('ProductCategories', [
            'foreignKey' => 'product_category_id',
            'className' => 'AdminPanel.ProductCategories'
        ]);
        $this->belongsTo('Browsers', [
            'foreignKey' => 'browser_id',
            'className' => 'AdminPanel.Browsers'
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
        $rules->add($rules->existsIn(['search_term_id'], 'SearchTerms'));
        $rules->add($rules->existsIn(['product_category_id'], 'ProductCategories'));
        $rules->add($rules->existsIn(['browser_id'], 'Browsers'));

        return $rules;
    }
}
