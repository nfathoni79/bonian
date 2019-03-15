<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\CustomerCartDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\CustomerCartDetailsTable Test Case
 */
class CustomerCartDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\CustomerCartDetailsTable
     */
    public $CustomerCartDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.CustomerCartDetails',
        'plugin.AdminPanel.CustomerCarts',
        'plugin.AdminPanel.Products',
        'plugin.AdminPanel.ProductOptionPrices',
        'plugin.AdminPanel.ProductOptionStocks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CustomerCartDetails') ? [] : ['className' => CustomerCartDetailsTable::class];
        $this->CustomerCartDetails = TableRegistry::getTableLocator()->get('CustomerCartDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomerCartDetails);

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
