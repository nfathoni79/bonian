<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SearchStats Model
 *
 * @property \AdminPanel\Model\Table\SearchTermsTable|\Cake\ORM\Association\BelongsTo $SearchTerms
 * @property \AdminPanel\Model\Table\BrowsersTable|\Cake\ORM\Association\BelongsTo $Browsers
 * @property \AdminPanel\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \AdminPanel\Model\Entity\SearchStat get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\SearchStat newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchStat[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchStat|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\SearchStat|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\SearchStat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchStat[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchStat findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SearchStatsTable extends Table
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

        $this->setTable('search_stats');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('SearchTerms', [
            'foreignKey' => 'search_term_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.SearchTerms'
        ]);
        $this->belongsTo('Browsers', [
            'foreignKey' => 'browser_id',
            'className' => 'AdminPanel.Browsers'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'className' => 'AdminPanel.Customers'
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
        $rules->add($rules->existsIn(['browser_id'], 'Browsers'));
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));

        return $rules;
    }
}
