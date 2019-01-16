<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AttributeGroups Model
 *
 * @property \AdminPanel\Model\Table\AttributesTable|\Cake\ORM\Association\HasMany $Attributes
 *
 * @method \AdminPanel\Model\Entity\AttributeGroup get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\AttributeGroup newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\AttributeGroup[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\AttributeGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\AttributeGroup|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\AttributeGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\AttributeGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\AttributeGroup findOrCreate($search, callable $callback = null, $options = [])
 */
class AttributeGroupsTable extends Table
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

        $this->setTable('attribute_groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Attributes', [
            'foreignKey' => 'attribute_group_id',
            'className' => 'AdminPanel.Attributes'
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

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->integer('sort_order')
            ->allowEmptyString('sort_order');

        return $validator;
    }
}
