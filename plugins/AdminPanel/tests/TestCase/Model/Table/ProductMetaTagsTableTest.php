<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\ProductMetaTagsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\ProductMetaTagsTable Test Case
 */
class ProductMetaTagsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\ProductMetaTagsTable
     */
    public $ProductMetaTags;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.ProductMetaTags',
        'plugin.AdminPanel.Products'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ProductMetaTags') ? [] : ['className' => ProductMetaTagsTable::class];
        $this->ProductMetaTags = TableRegistry::getTableLocator()->get('ProductMetaTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductMetaTags);

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
