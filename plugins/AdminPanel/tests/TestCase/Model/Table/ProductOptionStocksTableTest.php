<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\ProductOptionStocksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\ProductOptionStocksTable Test Case
 */
class ProductOptionStocksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\ProductOptionStocksTable
     */
    public $ProductOptionStocks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.ProductOptionStocks',
        'plugin.AdminPanel.Products',
        'plugin.AdminPanel.ProductOptionPrices',
        'plugin.AdminPanel.Branches',
        'plugin.AdminPanel.ProductStockMutations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProductOptionStocks') ? [] : ['className' => ProductOptionStocksTable::class];
        $this->ProductOptionStocks = TableRegistry::getTableLocator()->get('ProductOptionStocks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductOptionStocks);

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
