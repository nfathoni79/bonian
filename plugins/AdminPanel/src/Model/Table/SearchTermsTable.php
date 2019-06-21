<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SearchTerms Model
 *
 * @property \AdminPanel\Model\Table\SearchCategoriesTable|\Cake\ORM\Association\HasMany $SearchCategories
 * @property \AdminPanel\Model\Table\SearchStatsTable|\Cake\ORM\Association\HasMany $SearchStats
 *
 * @method \AdminPanel\Model\Entity\SearchTerm get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\SearchTerm newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchTerm[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchTerm|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\SearchTerm|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\SearchTerm patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchTerm[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\SearchTerm findOrCreate($search, callable $callback = null, $options = [])
 */
class SearchTermsTable extends Table
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

        $this->setTable('search_terms');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('SearchCategories', [
            'foreignKey' => 'search_term_id',
            'className' => 'AdminPanel.SearchCategories'
        ]);
        $this->hasMany('SearchStats', [
            'foreignKey' => 'search_term_id',
            'className' => 'AdminPanel.SearchStats'
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
            ->scalar('words')
            ->maxLength('words', 255)
            ->requirePresence('words', 'create')
            ->allowEmptyString('words', false);

        $validator
            ->integer('hits')
            ->requirePresence('hits', 'create')
            ->allowEmptyString('hits', false);

        $validator
            ->boolean('match')
            ->requirePresence('match', 'create')
            ->allowEmptyString('match', false);

        return $validator;
    }
}
