<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PriceSettings Model
 *
 * @property \AdminPanel\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \AdminPanel\Model\Table\PriceSettingDetailsTable|\Cake\ORM\Association\HasMany $PriceSettingDetails
 *
 * @method \AdminPanel\Model\Entity\PriceSetting get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\PriceSetting newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\PriceSetting[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\PriceSetting|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\PriceSetting|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\PriceSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\PriceSetting[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\PriceSetting findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PriceSettingsTable extends Table
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

        $this->setTable('price_settings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Users'
        ]);
        $this->hasMany('PriceSettingDetails', [
            'foreignKey' => 'price_setting_id',
            'className' => 'AdminPanel.PriceSettingDetails'
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

//        $validator
//            ->scalar('filename')
//            ->maxLength('filename', 50)
//            ->requirePresence('filename', 'create')
//            ->allowEmptyFile('filename', false);

        $validator
            ->date('schedule')
            ->requirePresence('schedule', 'create')
            ->allowEmptyDate('schedule', false);

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->allowEmptyString('status', false);

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
