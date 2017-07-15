<?php
namespace SwissRounds\Controller;

use SwissRounds\Controller\AppController;

/**
 * Teams Controller
 *
 * @property \SwissRounds\Model\Table\TeamsTable $Teams
 */
class TeamsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate['contain'] = ['Players', 'Tournaments'];
		$this->paginate['order'][] = 'tournament_id';
        $teams = $this->paginate($this->Teams);
			
        $this->set(compact('teams'));
        $this->set('_serialize', ['teams']);
    }

    /**
     * View method
     *
     * @param string|null $id Team id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $team = $this->Teams->get($id, [
            'contain' => ['Matches', 'Players', 'Tournaments']
        ]);

        $this->set('team', $team);
        $this->set('_serialize', ['team']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $team = $this->Teams->newEntity(['associated' => ['Players']]);
        if ($this->request->is('post')) {
            $team = $this->Teams->patchEntity($team, $this->request->data);
            if ($this->Teams->save($team)) {
                $this->Flash->success(__('The team has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The team could not be saved. Please, try again.'));
            }
        }
        $matches = $this->Teams->Matches->find('list', ['limit' => 200]);
        $tournaments = $this->Teams->Tournaments->find('list', ['limit' => 200]);
        $this->set(compact('team', 'matches', 'tournaments'));
        $this->set('_serialize', ['team']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Team id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $team = $this->Teams->get($id, [
            'contain' => ['Players', 'Matches', 'Tournaments']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $team = $this->Teams->patchEntity($team, $this->request->data,  ['associated' => ['players']]);

            if($team->updateScore()) {
                $this->Flash->success(__('Team points updated.'));
            }

            if ($this->Teams->save($team, ['associated' => 'Players'])) {
                $this->Flash->success(__('The team has been saved.'));
            } else {
                $this->Flash->error(__('The team could not be saved. Please, try again.'));
            }
        }

		$team = $this->Teams->get($id, [
            'contain' => ['Players', 'Matches', 'Tournaments']
        ]);
		
        $player = $this->Teams->Players->find('list', ['limit' => 200]);
        $tournaments = $this->Teams->Tournaments->find('list', ['limit' => 200]);
        $this->set(compact('team', 'player', 'tournaments'));
        $this->set('_serialize', ['team']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Team id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        // $this->request->allowMethod(['post', 'delete']);

        $team = $this->Teams->get($id, ['associated' => ['Matches', 'Players']]);

        $matches = $this->Teams->Matches->find('all');
        $matches = $matches->toArray();

        if(count($matches) > 0) {
            $this->Flash->error(__('This team can\'t be deleted because it already played in the tournament.'));
        } else {
            if ($this->Teams->delete($team)) {
                $this->Flash->success(__('The team has been deleted.'));
            } else {
                $this->Flash->error(__('The team could not be deleted. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
