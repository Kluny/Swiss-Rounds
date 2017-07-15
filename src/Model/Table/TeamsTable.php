<?php
namespace SwissRounds\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Teams Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Tournaments
 * @property \Cake\ORM\Association\HasMany $Players
 * @property \Cake\ORM\Association\BelongsToMany $Matches
 *
 * @method \SwissRounds\Model\Entity\Team get($primaryKey, $options = [])
 * @method \SwissRounds\Model\Entity\Team newEntity($data = null, array $options = [])
 * @method \SwissRounds\Model\Entity\Team[] newEntities(array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Team|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SwissRounds\Model\Entity\Team patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Team[] patchEntities($entities, array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Team findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TeamsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('teams');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Tournaments', [
            'foreignKey' => 'tournament_id',
           
		   //when it's an inner join, teams that don't have a tournament aren't included in the index.
		   // 'joinType' => 'INNER',
            'className' => 'SwissRounds.Tournaments'
        ]);
        $this->hasMany('Players', [
            'foreignKey' => 'team_id',
            'className' => 'SwissRounds.Players',
			'dependent' => true,
			'cascadeCallbacks' => true,
        ]);
        $this->belongsToMany('Matches', [
            'foreignKey' => 'team_id',
            'targetForeignKey' => 'match_id',
            'joinTable' => 'matches_teams',
            'className' => 'SwissRounds.Matches'
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

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('tournament_points')
            ->allowEmpty('tournament_points');

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
        $rules->add($rules->existsIn(['tournament_id'], 'Tournaments'));

        return $rules;
    }
}
