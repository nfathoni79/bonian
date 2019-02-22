<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\ProductOptionValueListsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\ProductOptionValueListsTable Test Case
 */
class ProductOptionValueListsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\ProductOptionValueListsTable
     */
    public $ProductOptionValueLists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.ProductOptionValueLists',
        'plugin.AdminPanel.ProductOptionPrices',
        'plugin.AdminPanel.OptionValues'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProductOptionValueLists') ? [] : ['className' => ProductOptionValueListsTable::class];
        $this->ProductOptionValueLists = TableRegistry::getTableLocator()->get('ProductOptionValueLists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductOptionValueLists);

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
