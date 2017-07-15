<?php
namespace SwissRounds\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use SwissRounds\Model\Table\PlayersTable;

/**
 * SwissRounds\Model\Table\PlayersTable Test Case
 */
class PlayersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \SwissRounds\Model\Table\PlayersTable
     */
    public $Players;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.swiss_rounds.players',
        'plugin.swiss_rounds.teams',
        'plugin.swiss_rounds.matches',
        'plugin.swiss_rounds.matches_teams'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Players') ? [] : ['className' => 'SwissRounds\Model\Table\PlayersTable'];
        $this->Players = TableRegistry::get('Players', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Players);

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
