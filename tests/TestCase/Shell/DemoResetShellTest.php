<?php
namespace App\Test\TestCase\Shell;

use App\Shell\DemoResetShell;
use Cake\TestSuite\TestCase;

/**
 * App\Shell\DemoResetShell Test Case
 */
class DemoResetShellTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMock('Cake\Console\ConsoleIo');
        $this->DemoReset = new DemoResetShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DemoReset);

        parent::tearDown();
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
