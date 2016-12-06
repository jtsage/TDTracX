<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CalendarsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CalendarsTable Test Case
 */
class CalendarsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CalendarsTable
     */
    public $Calendars;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.calendars',
        'app.shows',
        'app.budgets',
        'app.payrolls',
        'app.users',
        'app.messages',
        'app.show_user_perms'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Calendars') ? [] : ['className' => 'App\Model\Table\CalendarsTable'];
        $this->Calendars = TableRegistry::get('Calendars', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Calendars);

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
