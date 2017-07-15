<?php
namespace SwissRounds\Controller;
use SwissRounds\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Session\DatabaseSession;
use Cake\Controller\Component\CookieComponent;

/**
 * Rounds Controller
 *
 * @property \SwissRounds\Model\Table\RoundsTable $Rounds
 */
class RoundsController extends AppController
{
	public function finishRound($id) {
		$this->viewBuilder()->autoLayout(false);

		$round = $this->Rounds->get($id, [
            'contain' => ['Tournaments' => ['Teams' => ['Matches']]]
        ]);

		$success = true;
		foreach ($round->tournament->teams as $team) {
			if($team->updateScore()) {
				if($this->Rounds->Tournaments->Teams->save($team)) {
				} else {
					$success = false;
				}
			} else {
				$success = false;
			}
		}

		if($success) {
			$this->request->session()->delete('Round.inProgress');
			$this->Flash->success(__('The round has been saved.'));
		} else {
			$this->Flash->error(__('The round could not be saved.'));
		}

		$this->redirect(['controller' => 'tournaments', 'action' => 'view', $round->tournament_id]);  //' . $round->tournament_id);
	}

    public function ajaxAddRound($tournamentId)   {
		$this->viewBuilder()->autoLayout(false);

	    if ($this->request->is('ajax')) {
	    //    $this->autoRender = false;
	          $round = $this->Rounds->newEntity();
	          if ($this->request->is('get')) {
			    $round->tournament_id = $tournamentId;
                $round = $this->Rounds->patchEntity($round, $this->request->data);
                if ($this->Rounds->save($round)) {
                    $match = $this->Rounds->Matches->newEntity();

					$teams = $this->Rounds->Tournaments->Teams->find('all',
							['conditions' =>
									['tournament_id' => $tournamentId],
								'contain' =>
									['Matches'],
								'order' => ['tournament_points DESC',
											'points_spread DESC'
											]
							]
						);
					$matches = $this->_createMatches($teams->toArray());

					$tournament = $this->Rounds->Tournaments->get($tournamentId,
									['contain' =>
										['Teams' =>
											['sort' =>
												['Teams.tournament_points' => 'DESC']
											]]]);

					$this->set(compact('matches', 'tournament', 'round'));

					$this->request->session()->write('Round.inProgress', compact('matches', 'tournament', 'round'));
					//$this->request->cookie()->write('Round', compact('matches', 'tournament', 'round'));
                } else {
                    $this->response->body('Something went wrong.');
                    return $this->response;
                }
	        }
	   	}
    }

	// This function takes a list of teams, containing matches, and returns pairs of teams for the next round.
	// The goal is to ensure that every team gets a chance to play every other team in a tournament.
	// There's potential trouble here in the future if teams are resued in multiple tournaments.
	// Namely, two teams might find that they have matches in common from a past tournament, and thus
	// 	never get matched in the current one. However, this can be dealt with by ensuring that only matches
	// 	belonging to the current round, and rounds belonging to the current tourney, are selected.

	public function _createMatches($teams = array(), $matchedTeams = array(), $i = 0) {
        // If there is only one team left, it's the odd man out. It gets a bye, if desired. Or it can play irregulars.
        if(count($teams) == 1) {
            // Remove the one team from the array so it will be empty for the next "if"
            $team_a = array_pop($teams);
            // Make a subarray with that team
            $match = [$team_a];
            // Add it to the return array.
            $matchedTeams[] = $match;
        }

		$data = "count teams: " . count($teams) . "  \n";

        // If there are no teams left in the teams array
		if(!empty($teams)) {

			$data .= "teams is not empty: " . count($teams) . "  \n";
            // Pop the last item off the array. So, Winnipeg on the first iteration.
			$team_a = array_shift($teams);

			$data .= "team a: " . $team_a->name . "  \n";


            // Iterate the rest of the team.
			foreach($teams as $k => $team_b) {
				$data .= "team b: " . $team_b->name . "  \n";

                // Make two arrays out of the previous matches of the two teams, using only the ID field.
				$team_a_matches = array_column($team_a->matches, 'id');
				$team_b_matches = array_column($team_b->matches, 'id');

				$data .= "team a match ids: " . print_r($team_a_matches, true) . "  \n";
				$data .= "team b match ids: " . print_r($team_b_matches, true) . "  \n";

				$data .= "have these guys played each other yet? " . " \n";

                // Do the two teams have any matches in common?
				$intersection = array_intersect($team_a_matches, $team_b_matches);

                // We start a counter at zero. if the teams have zero or less matches in common, it's a valid match.
				if(count($intersection) <= $i) {
					$data .= "there's no intersection. they haven't played each other." . " \n";
					$data .= "counter i is at " . $i . " \n";
					$data .= "count intersection is " . count($intersection) . " \n";
					$data .= "intersection" . print_r($intersection, true) . " \n";

					// In that case, we make a subarray out of the id's of the popped off match, and the one we just found.
					$match = [$team_a, $team_b];

                    // Add the match to the return array.
					$matchedTeams[] = $match;
					$data .= "these guys are matched." . " \n";
					$data .= "match: " . $team_a->name . " vs " . $team_b->name . "  \n";

					$i = -1;
                    // We take the other matched team off the list as well.
					unset($teams[$k]);
                    // And we'll break the loop. Because this is a recursive function. The loop doesn't continue, it calls itself.
                    break;
				} else {
					$data .= "yes they have." . " \n";

				}
			}

			//mail('shannon@rocketships.ca', 'data', $data);

			if(empty($match)) { // no match was found
				$teams[] = $team_a; // put that bad boy back on.
			}

            // Reset the array keys...
			$teams = array_values($teams);

            //... and call the function again.
            return $this->_createMatches($teams, $matchedTeams, $i + 1);

		}

		return $matchedTeams;
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tournaments']
        ];
        $rounds = $this->paginate($this->Rounds);

        $this->set(compact('rounds'));
        $this->set('_serialize', ['rounds']);
    }

    /**
     * View method
     *
     * @param string|null $id Round id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $round = $this->Rounds->get($id, [
            'contain' => ['Tournaments', 'Matches']
        ]);

        $this->set('round', $round);
        $this->set('_serialize', ['round']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $round = $this->Rounds->newEntity();
        if ($this->request->is('post')) {
            $round = $this->Rounds->patchEntity($round, $this->request->data);
            if ($this->Rounds->save($round)) {
                $this->Flash->success(__('The round has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The round could not be saved. Please, try again.'));
            }
        }
        $tournaments = $this->Rounds->Tournaments->find('list', ['limit' => 200]);
        $teams = $this->Rounds->Matches->Teams->find('list', ['limit' => 200]);
        $this->set(compact('round', 'tournaments', 'teams'));
        $this->set('_serialize', ['round']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Round id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $round = $this->Rounds->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $round = $this->Rounds->patchEntity($round, $this->request->data);
            if ($this->Rounds->save($round)) {
                $this->Flash->success(__('The round has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The round could not be saved. Please, try again.'));
            }
        }
        $tournaments = $this->Rounds->Tournaments->find('list', ['limit' => 200]);
        $this->set(compact('round', 'tournaments'));
        $this->set('_serialize', ['round']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Round id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $round = $this->Rounds->get($id);
        if ($this->Rounds->delete($round)) {
            $this->Flash->success(__('The round has been deleted.'));
        } else {
            $this->Flash->error(__('The round could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
