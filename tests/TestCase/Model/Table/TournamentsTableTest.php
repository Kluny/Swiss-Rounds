<?php
namespace SwissRounds\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use SwissRounds\Model\Table\TournamentsTable;

/**
 * SwissRounds\Model\Table\TournamentsTable Test Case
 */
class TournamentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \SwissRounds\Model\Table\TournamentsTable
     */
    public $Tournaments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.swiss_rounds.tournaments',
        'plugin.swiss_rounds.rounds',
        'plugin.swiss_rounds.matches',
        'plugin.swiss_rounds.teams',
        'plugin.swiss_rounds.players',
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
        $config = TableRegistry::exists('Tournaments') ? [] : ['className' => 'SwissRounds\Model\Table\TournamentsTable'];
        $this->Tournaments = TableRegistry::get('Tournaments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tournaments);

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
