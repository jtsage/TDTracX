<?php
namespace App\Test\TestCase\Shell;

use App\Shell\InstallerShell;
use Cake\TestSuite\TestCase;

/**
 * App\Shell\InstallerShell Test Case
 */
class InstallerShellTest extends TestCase
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
        $this->Installer = new InstallerShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Installer);

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
