<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AuthCodes Model
 *
 * @method \AdminPanel\Model\Entity\AuthCode get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\AuthCode newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\AuthCode[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\AuthCode|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\AuthCode|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\AuthCode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\AuthCode[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\AuthCode findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AuthCodesTable extends Table
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

        $this->setTable('auth_codes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->notEmpty('name');


        $validator
            ->scalar('code')
            ->maxLength('code', 8)
            ->allowEmpty('code');

        $validator
            ->dateTime('expired')
            ->allowEmpty('expired');

        return $validator;
    }
}
