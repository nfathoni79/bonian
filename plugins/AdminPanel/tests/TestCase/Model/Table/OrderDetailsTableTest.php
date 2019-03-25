<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\OrderDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\OrderDetailsTable Test Case
 */
class OrderDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\OrderDetailsTable
     */
    public $OrderDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.OrderDetails',
        'plugin.AdminPanel.Orders',
        'plugin.AdminPanel.Branches',
        'plugin.AdminPanel.Courriers',
        'plugin.AdminPanel.Provinces',
        'plugin.AdminPanel.Cities',
        'plugin.AdminPanel.Subdistricts',
        'plugin.AdminPanel.OrderStatuses',
        'plugin.AdminPanel.Chats',
        'plugin.AdminPanel.OrderDetailProducts',
        'plugin.AdminPanel.OrderShippingDetails'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OrderDetails') ? [] : ['className' => OrderDetailsTable::class];
        $this->OrderDetails = TableRegistry::getTableLocator()->get('OrderDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrderDetails);

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
