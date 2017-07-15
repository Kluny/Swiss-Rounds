<?php
namespace SwissRounds\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tournaments Model
 *
 * @property \Cake\ORM\Association\HasMany $Rounds
 * @property \Cake\ORM\Association\HasMany $Teams
 *
 * @method \SwissRounds\Model\Entity\Tournament get($primaryKey, $options = [])
 * @method \SwissRounds\Model\Entity\Tournament newEntity($data = null, array $options = [])
 * @method \SwissRounds\Model\Entity\Tournament[] newEntities(array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Tournament|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SwissRounds\Model\Entity\Tournament patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Tournament[] patchEntities($entities, array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Tournament findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TournamentsTable extends Table
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

        $this->table('tournaments');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Rounds', [
            'foreignKey' => 'tournament_id',
            'className' => 'SwissRounds.Rounds'
        ]);
        $this->hasMany('Teams', [
            'foreignKey' => 'tournament_id',
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

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
}
