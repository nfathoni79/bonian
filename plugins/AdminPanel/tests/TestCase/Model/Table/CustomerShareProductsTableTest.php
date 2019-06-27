<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\CustomerShareProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\CustomerShareProductsTable Test Case
 */
class CustomerShareProductsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\CustomerShareProductsTable
     */
    public $CustomerShareProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.CustomerShareProducts',
        'plugin.AdminPanel.Customers',
        'plugin.AdminPanel.Products',
        'plugin.AdminPanel.Orders'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CustomerShareProducts') ? [] : ['className' => CustomerShareProductsTable::class];
        $this->CustomerShareProducts = TableRegistry::getTableLocator()->get('CustomerShareProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomerShareProducts);

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
