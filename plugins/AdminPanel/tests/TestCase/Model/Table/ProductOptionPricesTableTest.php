<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\ProductOptionPricesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\ProductOptionPricesTable Test Case
 */
class ProductOptionPricesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\ProductOptionPricesTable
     */
    public $ProductOptionPrices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.ProductOptionPrices',
        'plugin.AdminPanel.Products',
        'plugin.AdminPanel.ProductOptionStocks',
        'plugin.AdminPanel.ProductOptionValueLists'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProductOptionPrices') ? [] : ['className' => ProductOptionPricesTable::class];
        $this->ProductOptionPrices = TableRegistry::getTableLocator()->get('ProductOptionPrices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductOptionPrices);

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
