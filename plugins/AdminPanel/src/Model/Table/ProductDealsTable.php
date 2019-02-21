<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductDeals Model
 *
 * @property \AdminPanel\Model\Table\ProductDealDetailsTable|\Cake\ORM\Association\HasMany $ProductDealDetails
 *
 * @method \AdminPanel\Model\Entity\ProductDeal get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ProductDeal newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductDeal[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductDeal|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductDeal|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductDeal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductDeal[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductDeal findOrCreate($search, callable $callback = null, $options = [])
 */
class ProductDealsTable extends Table
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

        $this->setTable('product_deals');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('ProductDealDetails', [
            'foreignKey' => 'product_deal_id',
            'className' => 'AdminPanel.ProductDealDetails'
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
            ->maxLength('name', 15)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->dateTime('date_start')
            ->requirePresence('date_start', 'create')
            ->allowEmptyDateTime('date_start', false);

        $validator
            ->dateTime('date_end')
            ->requirePresence('date_end', 'create')
            ->allowEmptyDateTime('date_end', false);

//        $validator
//            ->integer('status')
//            ->requirePresence('status', 'create')
//            ->allowEmptyString('status', false);

        return $validator;
    }
}
