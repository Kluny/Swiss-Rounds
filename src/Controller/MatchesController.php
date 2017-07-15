<?php
namespace SwissRounds\Controller;

use SwissRounds\Controller\AppController;

/**
 * Matches Controller
 *
 * @property \SwissRounds\Model\Table\MatchesTable $Matches
 */
class MatchesController extends AppController
{
	public function ajaxAddMatch($tournamentId, $roundId)
	{
		$this->viewBuilder()->autoLayout(false);
        $this->set('tournament', $this->Matches->Rounds->Tournaments->get($tournamentId, ['contain' => ['Teams']]));
        $this->set('round', $this->Matches->Rounds->get($roundId));
    }

    public function ajaxSaveMatch($tournamentId = null)
    {
		$this->viewBuilder()->autoLayout(false);

        if (!$this->request->is('ajax')) {
			die;
        }

        $match = $this->Matches->newEntity(['associated' => ['Teams']]);

        if ($this->request->is('post')) {
            $match = $this->Matches->patchEntity($match, $this->request->data, [
                'associated' => [
                    'Teams'
                ]
            ]);
			// a beforeSave callback checks that the match is valid and enters the winner's id,
			// or tie = true in the case of a tie.
            if ($this->Matches->save($match)) {
                //we end up seeing this message like 5 times - it's unneeded.
				//$this->Flash->success(__('The match has been saved.'));

                $lastMatch = $this->Matches->get($match->id, [
                    'contain' => ['Teams', 'Rounds']
                ]);
                $this->set('match', $lastMatch);

            } else {
				//todo: move HTML to an element
				echo "<div class='no-save'>The match could not be saved with the following input:" . "<br><br>"
						. "Team 1: " . $match->teams[0]->name . " Score: " . $match->teams[0]->_joinData['points_scored'] . "<br>"
						. "Team 2: " . $match->teams[1]->name . " Score: " . $match->teams[1]->_joinData['points_scored'] . "<br><br>"
						. "Please try again.</div>";
				die;
                //$this->Flash->error(__('The match could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Rounds', 'Teams']
        ];
        $matches = $this->paginate($this->Matches);
        $teams = $this->Matches->Teams->find('all');
        $this->set(compact('matches', 'teams'));
        $this->set('_serialize', ['matches']);
    }

    /**
     * View method
     *
     * @param string|null $id Match id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $match = $this->Matches->get($id, [
            'contain' => ['Rounds', 'Teams']
        ]);

        $this->set('match', $match);
        $this->set('_serialize', ['match']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $match = $this->Matches->newEntity();
        if ($this->request->is('post')) {
            $match = $this->Matches->patchEntity($match, $this->request->data);
            if ($this->Matches->save($match)) {
                $this->Flash->success(__('The match has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The match could not be saved. Please, try again.'));
            }
        }
        $rounds = $this->Matches->Rounds->find('list', ['limit' => 200]);
        $teams = $this->Matches->Teams->find('list', ['limit' => 200]);
        $this->set(compact('match', 'rounds', 'teams'));
        $this->set('_serialize', ['match']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Match id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$match = $this->Matches->get($id, [
			'contain' => [
				'Rounds',
				'Teams' => ['Matches']
			]
		]);

        if ($this->request->is(['patch', 'post', 'put'])) {
			$match = $this->Matches->patchEntity($match, $this->request->data,
													['associated' => [
														'Rounds',
														'Teams' => ['Matches']
													]]);

			if ($this->Matches->save($match)) {
                $this->Flash->success(__('The match has been saved.'));

            } else {
                $this->Flash->error(__('The match could not be saved. Please, try again.'));
            }

			//here is where we update the team scores after the match has been edited.
			foreach ($this->request->data['teams'] as $team) {
				$toSave = $this->Matches->Teams->get($team['id'], [
					'contain' => ['Matches']
				]);

				if($toSave->updateScore()) {
					if($this->Matches->Teams->save($toSave)) {
						$this->Flash->success(__($toSave->name . ' points updated.'));
					}
				} else {
					$this->Flash->error(__($toSave->name . ' points could not be saved.'));
				}
			}

        }

        $this->set(compact('match'));
        $this->set('_serialize', ['match']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Match id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $match = $this->Matches->get($id);
        if ($this->Matches->delete($match)) {
            $this->Flash->success(__('The match has been deleted.'));
        } else {
            $this->Flash->error(__('The match could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
