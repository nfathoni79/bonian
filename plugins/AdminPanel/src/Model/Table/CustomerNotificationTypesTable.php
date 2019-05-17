<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerNotificationTypes Model
 *
 * @property \AdminPanel\Model\Table\CustomerNotificationsTable|\Cake\ORM\Association\HasMany $CustomerNotifications
 *
 * @method \AdminPanel\Model\Entity\CustomerNotificationType get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\CustomerNotificationType newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerNotificationType[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerNotificationType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\CustomerNotificationType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\CustomerNotificationType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerNotificationType[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\CustomerNotificationType findOrCreate($search, callable $callback = null, $options = [])
 */
class CustomerNotificationTypesTable extends Table
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

        $this->setTable('customer_notification_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('CustomerNotifications', [
            'foreignKey' => 'customer_notification_type_id',
            'className' => 'AdminPanel.CustomerNotifications'
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
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        return $validator;
    }
}
