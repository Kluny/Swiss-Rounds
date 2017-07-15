<?php
namespace SwissRounds\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Match Entity
 *
 * @property int $id
 * @property int $round_id
 * @property int $winner
 * @property \Cake\I18n\Time $created
 *
 * @property \SwissRounds\Model\Entity\Round $round
 * @property \SwissRounds\Model\Entity\Team[] $teams
 */
class Match extends Entity
{

	// Increments points for winners, logs winner and ties.
	public function logWinner() {
		if($this->isValidMatch()) {
			$this->teams[0]->_joinData->tie = false;
			$this->teams[1]->_joinData->tie = false;

			$this->teams[0]->_joinData->winner = false;
			$this->teams[1]->_joinData->winner = false;

			$team_0_points = $this->teams[0]->_joinData->points_scored;
			$team_1_points = $this->teams[1]->_joinData->points_scored;
			$difference = abs($team_0_points - $team_1_points );

			$this->points_differential = $difference;

			if($team_0_points == $team_1_points) {
				$this->teams[0]->_joinData->tie = true;
				$this->teams[1]->_joinData->tie = true;

			} else if ($team_0_points > $team_1_points) {
				$this->teams[0]->_joinData->winner = true;
				$this->winner = $this->teams[0]->id;
			} else {
				$this->teams[1]->_joinData->winner = true;
				$this->winner = $this->teams[1]->id;
			}

			return true;
		}
		return false;
	}

	public function logPointSpread() {

	}

	// This function is used when an odd team gets an opponent chosen for them.
	//  Given a match with two proposed teams, it determines if the match is valid.
	public function isValidMatch() {
		// if there aren't exactly two teams, return false
		if(count($this->teams) !== 2) {
			return false;
		}
		// if both teams have the same name, return false
		if($this->teams[0]->id === $this->teams[1]->id) {
			return false;
		}
		return true;
	}

	// Given a tournament, it figures out how many matches are needed per round, and returns that many
	//  new match entities. It may not be used.
    public function createMatches($tournamentId, $roundId) {

        //find all the teams for tournament id
        $team = TableRegistry::get('Teams');
        $teams = $team->find('all', ['conditions' => ['tournament_id' => $tournamentId]]);

        //create half that many Matches
        $matchCount = round($teams->count()/2);

		#$teams = $teams->toArray();
        $matches = array();
        for($i = 0; $i < $matchCount; $i++) {
			$matches[] = TableRegistry::get('Matches')->newEntity(['associated' => ['Teams']]);
			}
        return $matches;
    }


    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
