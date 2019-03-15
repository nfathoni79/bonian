<?php
namespace ADminPanel\Test\TestCase\Model\Table;

use ADminPanel\Model\Table\CustomerCartsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * ADminPanel\Model\Table\CustomerCartsTable Test Case
 */
class CustomerCartsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \ADminPanel\Model\Table\CustomerCartsTable
     */
    public $CustomerCarts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.ADminPanel.CustomerCarts',
        'plugin.ADminPanel.Customers',
        'plugin.ADminPanel.CustomerCartDetails'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CustomerCarts') ? [] : ['className' => CustomerCartsTable::class];
        $this->CustomerCarts = TableRegistry::getTableLocator()->get('CustomerCarts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CustomerCarts);

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
