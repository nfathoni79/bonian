<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\ShareStatisticsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\ShareStatisticsTable Test Case
 */
class ShareStatisticsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\ShareStatisticsTable
     */
    public $ShareStatistics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.ShareStatistics',
        'plugin.AdminPanel.Products',
        'plugin.AdminPanel.Customers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShareStatistics') ? [] : ['className' => ShareStatisticsTable::class];
        $this->ShareStatistics = TableRegistry::getTableLocator()->get('ShareStatistics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShareStatistics);

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
