<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductToCourriers Model
 *
 * @property \AdminPanel\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \AdminPanel\Model\Table\CourriersTable|\Cake\ORM\Association\BelongsTo $Courriers
 *
 * @method \AdminPanel\Model\Entity\ProductToCourrier get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ProductToCourrier newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductToCourrier[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductToCourrier|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductToCourrier|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductToCourrier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductToCourrier[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductToCourrier findOrCreate($search, callable $callback = null, $options = [])
 */
class ProductToCourriersTable extends Table
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

        $this->setTable('product_to_courriers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Products'
        ]);
        $this->belongsTo('Courriers', [
            'foreignKey' => 'courrier_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Courriers'
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
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['courrier_id'], 'Courriers'));

        return $rules;
    }
}
