<?php
namespace AdminPanel\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderDetailProductsFixture
 *
 */
class OrderDetailProductsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'order_detail_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'product_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'product_option_value_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'qty' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'price' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => ''],
        'total' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => ''],
        'comment' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'product_option_price_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'product_option_stock_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'in_flashsale' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'in_groupsale' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'order_detail_id' => ['type' => 'index', 'columns' => ['order_detail_id'], 'length' => []],
            'product_id' => ['type' => 'index', 'columns' => ['product_id'], 'length' => []],
            'product_option_value_id' => ['type' => 'index', 'columns' => ['product_option_value_id'], 'length' => []],
            'product_option_stock_id' => ['type' => 'index', 'columns' => ['product_option_stock_id'], 'length' => []],
            'product_option_price_id' => ['type' => 'index', 'columns' => ['product_option_price_id', 'product_option_stock_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'order_detail_products_ibfk_1' => ['type' => 'foreign', 'columns' => ['order_detail_id'], 'references' => ['order_details', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'order_detail_products_ibfk_2' => ['type' => 'foreign', 'columns' => ['product_id'], 'references' => ['products', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'order_detail_products_ibfk_3' => ['type' => 'foreign', 'columns' => ['product_option_value_id'], 'references' => ['option_values', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'order_detail_products_ibfk_4' => ['type' => 'foreign', 'columns' => ['product_option_price_id'], 'references' => ['product_option_prices', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'order_detail_products_ibfk_5' => ['type' => 'foreign', 'columns' => ['product_option_stock_id'], 'references' => ['product_option_stocks', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'order_detail_id' => 1,
                'product_id' => 1,
                'product_option_value_id' => 1,
                'qty' => 1,
                'price' => 1,
                'total' => 1,
                'comment' => 'Lorem ipsum dolor sit amet',
                'created' => '2019-03-25 03:31:22',
                'product_option_price_id' => 1,
                'product_option_stock_id' => 1,
                'in_flashsale' => 1,
                'in_groupsale' => 1
            ],
        ];
        parent::init();
    }
}
