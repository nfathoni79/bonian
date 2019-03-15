<?php
namespace AdminPanel\Test\TestCase\Command;

use AdminPanel\Command\ExpiredPointCommand;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * AdminPanel\Command\ExpiredPointCommand Test Case
 */
class ExpiredPointCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->useCommandRunner();
    }

    /**
     * Test buildOptionParser method
     *
     * @return void
     */
    public function testBuildOptionParser()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test execute method
     *
     * @return void
     */
    public function testExecute()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
