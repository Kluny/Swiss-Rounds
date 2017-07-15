<?php
namespace SwissRounds\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Matches Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Rounds
 * @property \Cake\ORM\Association\BelongsToMany $Teams
 *
 * @method \SwissRounds\Model\Entity\Match get($primaryKey, $options = [])
 * @method \SwissRounds\Model\Entity\Match newEntity($data = null, array $options = [])
 * @method \SwissRounds\Model\Entity\Match[] newEntities(array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Match|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SwissRounds\Model\Entity\Match patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Match[] patchEntities($entities, array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Match findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MatchesTable extends Table
{

    public function beforeSave($event, $match, $options) {
        if($match->logWinner()) {
            return true;
        }
        return false;
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('matches');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Rounds', [
            'foreignKey' => 'round_id',
            'joinType' => 'INNER',
            'className' => 'SwissRounds.Rounds'
        ]);
        $this->belongsToMany('Teams', [
            'foreignKey' => 'match_id',
            'targetForeignKey' => 'team_id',
            'joinTable' => 'matches_teams',
            'className' => 'SwissRounds.Teams'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

    /*    $validator
            ->integer('score_team_1')
            ->requirePresence('score_team_1', 'create')
            ->notEmpty('score_team_1');

        $validator
            ->integer('score_team_2')
            ->requirePresence('score_team_2', 'create')
            ->notEmpty('score_team_2');

        $validator
            ->requirePresence('winning_team_name', 'create')
            ->notEmpty('winning_team_name');

        $validator
            ->requirePresence('losing_team_name', 'create')
            ->notEmpty('losing_team_name'); */

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['round_id'], 'Rounds'));

        return $rules;
    }
}
