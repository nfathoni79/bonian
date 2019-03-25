<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\OrderDetailProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\OrderDetailProductsTable Test Case
 */
class OrderDetailProductsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\OrderDetailProductsTable
     */
    public $OrderDetailProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.OrderDetailProducts',
        'plugin.AdminPanel.OrderDetails',
        'plugin.AdminPanel.Products',
        'plugin.AdminPanel.OptionValues',
        'plugin.AdminPanel.ProductOptionPrices',
        'plugin.AdminPanel.ProductOptionStocks',
        'plugin.AdminPanel.ProductRatings'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrderDetailProducts') ? [] : ['className' => OrderDetailProductsTable::class];
        $this->OrderDetailProducts = TableRegistry::getTableLocator()->get('OrderDetailProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrderDetailProducts);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
