<?php
namespace SwissRounds\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use SwissRounds\Model\Table\PlayerTable;

/**
 * SwissRounds\Model\Table\PlayerTable Test Case
 */
class PlayerTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \SwissRounds\Model\Table\PlayerTable
     */
    public $Player;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.swiss_rounds.player',
        'plugin.swiss_rounds.teams'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Player') ? [] : ['className' => 'SwissRounds\Model\Table\PlayerTable'];
        $this->Player = TableRegistry::get('Player', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Player);

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
