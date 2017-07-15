<?php
namespace SwissRounds\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use SwissRounds\Model\Table\TeamTable;

/**
 * SwissRounds\Model\Table\TeamTable Test Case
 */
class TeamTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \SwissRounds\Model\Table\TeamTable
     */
    public $Team;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.swiss_rounds.team',
        'plugin.swiss_rounds.player',
        'plugin.swiss_rounds.teams',
        'plugin.swiss_rounds.match',
        'plugin.swiss_rounds.team1s',
        'plugin.swiss_rounds.team2s',
        'plugin.swiss_rounds.rounds',
        'plugin.swiss_rounds.winning_teams',
        'plugin.swiss_rounds.match_team'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Team') ? [] : ['className' => 'SwissRounds\Model\Table\TeamTable'];
        $this->Team = TableRegistry::get('Team', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Team);

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
