<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaqCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaqCategoriesTable Test Case
 */
class FaqCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FaqCategoriesTable
     */
    public $FaqCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FaqCategories',
        'app.Faqs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FaqCategories') ? [] : ['className' => FaqCategoriesTable::class];
        $this->FaqCategories = TableRegistry::getTableLocator()->get('FaqCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FaqCategories);

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
}
