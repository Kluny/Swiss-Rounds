<?php
namespace SwissRounds\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use SwissRounds\Model\Table\TournamentTable;

/**
 * SwissRounds\Model\Table\TournamentTable Test Case
 */
class TournamentTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \SwissRounds\Model\Table\TournamentTable
     */
    public $Tournament;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.swiss_rounds.tournament'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Tournament') ? [] : ['className' => 'SwissRounds\Model\Table\TournamentTable'];
        $this->Tournament = TableRegistry::get('Tournament', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tournament);

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
