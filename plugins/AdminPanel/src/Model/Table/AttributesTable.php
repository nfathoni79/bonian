<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Attributes Model
 *
 * @property \AdminPanel\Model\Table\ProductAttributesTable|\Cake\ORM\Association\HasMany $ProductAttributes
 *
 * @method \AdminPanel\Model\Entity\Attribute get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\Attribute newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\Attribute[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Attribute|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Attribute|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Attribute patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Attribute[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Attribute findOrCreate($search, callable $callback = null, $options = [])
 */
class AttributesTable extends Table
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

        $this->setTable('attributes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('ProductAttributes', [
            'foreignKey' => 'attribute_id',
            'className' => 'AdminPanel.ProductAttributes'
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
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        return $validator;
    }
}
