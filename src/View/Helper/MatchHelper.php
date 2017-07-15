<?php
namespace SwissRounds\View\Helper;

use Cake\View\Helper;

class MatchHelper extends Helper
{
	public $helpers = ['Html'];

    public function prettyPrintWinnerWinner($match = array()) {

        // if there are no associated teams, return false
        if(empty($match['teams'])) {
            return "Invalid match (1)";
        }
        // if there aren't two teams for some reason, return false
        if(count($match['teams']) != 2) {
            return "Invalid match (2)";
        }

        //if the points_scored value is null for some reason
        if(!isset($match['teams'][0]['_joinData']['points_scored']) || !isset($match['teams'][1]['_joinData']['points_scored'])) {
            return "Invalid match (3)";
        }

        if($match['teams'][0]['_joinData']['points_scored'] > $match['teams'][1]['_joinData']['points_scored']) {
            return $match['teams'][0]['name'] . " wins!";
        } else if($match['teams'][0]['_joinData']['points_scored'] < $match['teams'][1]['_joinData']['points_scored']) {
            return $match['teams'][1]['name'] . " wins!";
        } else if($match['teams'][0]['_joinData']['points_scored'] ==  $match['teams'][1]['_joinData']['points_scored']){
            return "Tie game!";
        }
    }


	public function addMatch($tournamentId, $roundId){
		return "<span class='add_match'>"
				. $this->Html->link('+New Match', ['controller' => 'matches',
										'action' => 'ajax_add_match',
										$tournamentId,
										$roundId,
                                    ], ['class' => 'add'])
				. "</span>";

	}
}
