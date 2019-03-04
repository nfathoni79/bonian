<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ActivityLogs Model
 *
 * @property \AdminPanel\Model\Table\ScopesTable|\Cake\ORM\Association\BelongsTo $Scopes
 * @property \AdminPanel\Model\Table\IssuersTable|\Cake\ORM\Association\BelongsTo $Issuers
 * @property \AdminPanel\Model\Table\ObjectsTable|\Cake\ORM\Association\BelongsTo $Objects
 *
 * @method \AdminPanel\Model\Entity\ActivityLog get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ActivityLog newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ActivityLog[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ActivityLog|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ActivityLog|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ActivityLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ActivityLog[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ActivityLog findOrCreate($search, callable $callback = null, $options = [])
 */
class ActivityLogsTable extends Table
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

        $this->setTable('activity_logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

//        $this->belongsTo('Scopes', [
//            'foreignKey' => 'scope_id',
//            'joinType' => 'INNER',
//            'className' => 'AdminPanel.Scopes'
//        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'issuer_id',
            'className' => 'AdminPanel.Users'
        ]);
//        $this->belongsTo('Objects', [
//            'foreignKey' => 'object_id',
//            'className' => 'AdminPanel.Objects'
//        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
//        $validator
//            ->allowEmptyString('id', 'create');
//
//        $validator
//            ->dateTime('created_at')
//            ->requirePresence('created_at', 'create')
//            ->allowEmptyDateTime('created_at', false);
//
//        $validator
//            ->scalar('scope_model')
//            ->maxLength('scope_model', 64)
//            ->requirePresence('scope_model', 'create')
//            ->allowEmptyString('scope_model', false);
//
//        $validator
//            ->scalar('issuer_model')
//            ->maxLength('issuer_model', 64)
//            ->allowEmptyString('issuer_model');
//
//        $validator
//            ->scalar('object_model')
//            ->maxLength('object_model', 64)
//            ->allowEmptyString('object_model');
//
//        $validator
//            ->scalar('level')
//            ->maxLength('level', 16)
//            ->requirePresence('level', 'create')
//            ->allowEmptyString('level', false);
//
//        $validator
//            ->scalar('action')
//            ->maxLength('action', 64)
//            ->allowEmptyString('action');
//
//        $validator
//            ->scalar('message')
//            ->allowEmptyString('message');
//
//        $validator
//            ->scalar('data')
//            ->allowEmptyString('data');

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
//        $rules->add($rules->existsIn(['scope_id'], 'Scopes'));
//        $rules->add($rules->existsIn(['issuer_id'], 'Issuers'));
//        $rules->add($rules->existsIn(['object_id'], 'Objects'));

        return $rules;
    }
}
