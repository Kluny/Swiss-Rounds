<?php
namespace SwissRounds\Model\Entity;

use Cake\ORM\Entity;
use Cake\Log\Log;

/**
 * Team Entity
 *
 * @property int $id
 * @property string $name
 * @property int $tournament_points
 * @property \Cake\I18n\Time $created
 * @property int $tournament_id
 *
 * @property \SwissRounds\Model\Entity\Tournament $tournament
 * @property \SwissRounds\Model\Entity\Player[] $players
 * @property \SwissRounds\Model\Entity\Match[] $matches
 */
class Team extends Entity
{

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


	public function updateScore() {
	// This function should take one team and its contained matches, and calculate its tournament score based on those matches.
        $points = 0;
        $diff = 0;

        if(empty($this->matches)) {
            return true;
        }

        //debug("count: " . count($this->matches));
        foreach($this->matches as $match) {
            if($match->_joinData->winner) {
                $points = $points + 2;
                $diff = $diff + $match->points_differential;
            } else {
                $diff = $diff - $match->points_differential;
            }

            if($match->_joinData->tie) {
                $points = $points + 1;
            }
        }
        $this->tournament_points = $points;
        $this->points_spread = $diff;
        //debug($this->name . ' : ' . $this->tournament_points);
        return true;
	}

/*    public function updatePointSpread() {
	    // This function should take one team and its contained matches, and calculate its tournament score based on those matches.
        $points = 0;

        if(empty($this->matches)) {
            return true;
        }

        //debug("count: " . count($this->matches));
        foreach($this->matches as $match) {
            //get absolute value of difference
            // if team won this match
                // add it to their score
            // else, subtract it.
                //more thought is required.

        }
        $this->point_spread = $points;
        //debug($this->name . ' : ' . $this->tournament_points);
        return true;
	} */
}
