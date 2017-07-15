<?php
namespace SwissRounds\Controller;

use SwissRounds\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * Tournaments Controller
 *
 * @property \SwissRounds\Model\Table\TournamentsTable $Tournaments
 */
class TournamentsController extends AppController
{

    public function clearScores($id) {
        $this->request->session()->delete('Round.inProgress');

        $conn = ConnectionManager::get('default');

        $stmt = $conn->execute(
                "DELETE FROM `matches`; DELETE FROM `matches_teams`; DELETE FROM `rounds`;
                    ALTER TABLE `matches` auto_increment = 1;
                    ALTER TABLE `rounds` auto_increment = 1;
                    ALTER TABLE `matches_teams` auto_increment = 1;
                    UPDATE `teams` set `tournament_points` = 0;
                    UPDATE `teams` set `points_spread` = 0;" );

        if($stmt) {
            $this->Flash->success(__('Tournament data cleared.'));
        } else {
            $this->Flash->error(__('Could not execute sql.'));
        }

        $this->redirect($this->referer());
    }

    public function clearTeamsPlayers($id) {
        $this->request->session()->delete('Round.inProgress');

        $conn = ConnectionManager::get('default');

        $stmt = $conn->execute(
                "DELETE FROM `teams` WHERE `tournament_id` = $id;
                 DELETE FROM `players` WHERE `tournament_id` = $id;");

        if($stmt) {
            $this->Flash->success(__('Player and team data cleared.'));
        } else {
            $this->Flash->error(__('Could not execute sql.'));
        }

        $this->redirect($this->referer());
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
      $this->paginate['contain'][] = 'Teams';

        $tournaments = $this->paginate($this->Tournaments);

        $this->set(compact('tournaments'));
        $this->set('_serialize', ['tournaments']);
    }

    /**
     * View method
     *
     * @param string|null $id Tournament id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tournament = $this->Tournaments->get($id,
			['contain' =>
                ['Rounds' => ['Matches'
						=> ['Teams']],
				 'Teams' => ['Players',
                                'Matches',
							    'sort' => ['Teams.tournament_points' => 'DESC',
                                            'Teams.points_spread' => 'DESC'
                                            ]
						    ]
				]]);

        $match = $this->Tournaments->Rounds->Matches->newEntity();
        $this->set(compact('tournament'));
        $this->set('_serialize', ['tournament']);

    }


    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tournament = $this->Tournaments->newEntity();
        if ($this->request->is('post')) {
            $tournament = $this->Tournaments->patchEntity($tournament, $this->request->data);
            if ($this->Tournaments->save($tournament)) {
                $this->Flash->success(__('The tournament has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The tournament could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('tournament'));
        $this->set('_serialize', ['tournament']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tournament id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tournament = $this->Tournaments->get($id, [
            'contain' => ['Teams' => ['Players']]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tournament = $this->Tournaments->patchEntity($tournament, $this->request->data);
            if ($this->Tournaments->save($tournament)) {
                $this->Flash->success(__('The tournament has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The tournament could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('tournament'));
        $this->set('_serialize', ['tournament']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tournament id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tournament = $this->Tournaments->get($id);
        if ($this->Tournaments->delete($tournament)) {
            $this->Flash->success(__('The tournament has been deleted.'));
        } else {
            $this->Flash->error(__('The tournament could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
