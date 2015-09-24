<?php
namespace App\Test\TestCase\Shell;

use App\Shell\TdtracShell;
use Cake\TestSuite\TestCase;

/**
 * App\Shell\TdtracShell Test Case
 */
class TdtracShellTest extends TestCase
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
        $this->Tdtrac = new TdtracShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tdtrac);

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
