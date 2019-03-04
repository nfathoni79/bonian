<?php
namespace AdminPanel\Test\TestCase\Model\Table;

use AdminPanel\Model\Table\PriceSettingDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Model\Table\PriceSettingDetailsTable Test Case
 */
class PriceSettingDetailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \AdminPanel\Model\Table\PriceSettingDetailsTable
     */
    public $PriceSettingDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.AdminPanel.PriceSettingDetails',
        'plugin.AdminPanel.PriceSettings',
        'plugin.AdminPanel.Products',
        'plugin.AdminPanel.ProductOptionPrices'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PriceSettingDetails') ? [] : ['className' => PriceSettingDetailsTable::class];
        $this->PriceSettingDetails = TableRegistry::getTableLocator()->get('PriceSettingDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PriceSettingDetails);

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
