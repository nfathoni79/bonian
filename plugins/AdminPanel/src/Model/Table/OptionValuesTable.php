<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * OptionValues Model
 *
 * @property \AdminPanel\Model\Table\OptionsTable|\Cake\ORM\Association\BelongsTo $Options
 * @property \AdminPanel\Model\Table\ProductOptionValuesTable|\Cake\ORM\Association\HasMany $ProductOptionValues
 *
 * @method \AdminPanel\Model\Entity\OptionValue get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\OptionValue findOrCreate($search, callable $callback = null, $options = [])
 */
class OptionValuesTable extends Table
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

        $this->setTable('option_values');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Elastic/ActivityLogger.Logger', [
            'scope' => [
                'OptionValues'
            ],
            'issuer' => \Cake\Core\Configure::read('User') ?
                \Cake\ORM\TableRegistry::get('AdminPanel.Users')->get(\Cake\Core\Configure::read('User.id'))
                : null
        ]);
        $this->belongsTo('Options', [
            'foreignKey' => 'option_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Options'
        ]);
        $this->hasMany('ProductOptionValues', [
            'foreignKey' => 'option_value_id',
            'className' => 'AdminPanel.ProductOptionValues'
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['option_id'], 'Options'));
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }

    public function getNameById($id = null){
        $getValues = $this->find()
            ->where(['id' => $id])
            ->first();
        return $getValues['name'];
    }




    public function getId($slug = null){


        $option = TableRegistry::get('Options');
        $result = [];
        $explodeSlug = array_map('trim',explode(',', $slug));
        foreach($explodeSlug as $vals){
            $explodeOption = array_map('trim',explode(':', $vals));
            $findOpt = $option->find()
                ->where(['name' => $explodeOption[0]])
                ->first();
            $id = null;
            if($findOpt){
                $id = $findOpt->get('id');
            }else{
                $entity = $option->newEntity();
                $entity->name = $explodeOption[0];
                $option->save($entity);
                $id = $entity->get('id');
            }

            $idVal = null;
            $findOptVal = $this->find()
                ->where(['name' => $explodeOption[1], 'option_id' => $id])
                ->first();
            if($findOptVal){
                $idVal = $findOptVal->get('id');
            }else{
                $entity = $this->newEntity();
                $entity->option_id = $id;
                $entity->name = $explodeOption[1];
                $this->save($entity);
                $idVal = $entity->get('id');
            }

            $result[$id] = $idVal;

        }

        return $result;

    }
}
