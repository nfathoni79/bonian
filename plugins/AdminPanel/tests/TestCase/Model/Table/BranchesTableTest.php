<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\BranchesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\BranchesTable Test Case
 */
class BranchesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\BranchesTable
     */
    public $Branches;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.Branches',
        'plugin.AdminPanel.Provinces',
        'plugin.AdminPanel.Cities',
        'plugin.AdminPanel.Subdistricts',
        'plugin.AdminPanel.OrderDetails',
        'plugin.AdminPanel.ProductBranches',
        'plugin.AdminPanel.ProductOptionValues',
        'plugin.AdminPanel.ProductStockMutations',
        'plugin.AdminPanel.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Branches') ? [] : ['className' => BranchesTable::class];
        $this->Branches = TableRegistry::getTableLocator()->get('Branches', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Branches);

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
