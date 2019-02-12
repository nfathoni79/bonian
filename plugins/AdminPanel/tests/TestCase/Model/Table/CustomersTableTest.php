<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\CustomersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\CustomersTable Test Case
 */
class CustomersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\CustomersTable
     */
    public $Customers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.Customers',
        'plugin.AdminPanel.RefferalCustomers',
        'plugin.AdminPanel.CustomerGroups',
        'plugin.AdminPanel.CustomerStatuses',
        'plugin.AdminPanel.ChatDetails',
        'plugin.AdminPanel.CustomerAddreses',
        'plugin.AdminPanel.CustomerBalances',
        'plugin.AdminPanel.CustomerBuyGroupDetails',
        'plugin.AdminPanel.CustomerBuyGroups',
        'plugin.AdminPanel.CustomerLogBrowsings',
        'plugin.AdminPanel.CustomerMutationAmounts',
        'plugin.AdminPanel.CustomerMutationPoints',
        'plugin.AdminPanel.CustomerTokens',
        'plugin.AdminPanel.CustomerVirtualAccount',
        'plugin.AdminPanel.Generations',
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
        $config = TableRegistry::getTableLocator()->exists('Customers') ? [] : ['className' => CustomersTable::class];
        $this->Customers = TableRegistry::getTableLocator()->get('Customers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Customers);

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
