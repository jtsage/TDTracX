<?php
namespace App\Test\TestCase\Shell;

use App\Shell\BiweeklyShell;
use Cake\TestSuite\TestCase;

/**
 * App\Shell\BiweeklyShell Test Case
 */
class BiweeklyShellTest extends TestCase
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
        $this->Biweekly = new BiweeklyShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Biweekly);

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
