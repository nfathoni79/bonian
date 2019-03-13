<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerCards Model
 *
 * @property \AdminPanel\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \AdminPanel\Model\Entity\CustomerCard get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCard newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCard[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCard|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCard|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCard patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCard[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerCard findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CustomerCardsTable extends Table
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

        $this->setTable('customer_cards');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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

        $validator
            ->boolean('is_primary')
            ->allowEmptyString('is_primary');

        $validator
            ->scalar('masked_card')
            ->maxLength('masked_card', 15)
            ->allowEmptyString('masked_card');

        $validator
            ->scalar('token')
            ->maxLength('token', 255)
            ->allowEmptyString('token');

        $validator
            ->dateTime('expired_at')
            ->allowEmptyDateTime('expired_at');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));

        return $rules;
    }
}
