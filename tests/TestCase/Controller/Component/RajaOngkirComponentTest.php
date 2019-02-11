<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\RajaOngkirComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\RajaOngkirComponent Test Case
 */
class RajaOngkirComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\RajaOngkirComponent
     */
    public $RajaOngkir;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->RajaOngkir = new RajaOngkirComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RajaOngkir);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
