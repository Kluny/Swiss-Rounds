<?php
namespace SwissRounds\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Players Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Teams
 *
 * @method \SwissRounds\Model\Entity\Player get($primaryKey, $options = [])
 * @method \SwissRounds\Model\Entity\Player newEntity($data = null, array $options = [])
 * @method \SwissRounds\Model\Entity\Player[] newEntities(array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Player|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SwissRounds\Model\Entity\Player patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Player[] patchEntities($entities, array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Player findOrCreate($search, callable $callback = null)
 */
class PlayersTable extends Table
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

        $this->table('players');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Teams', [
            'foreignKey' => 'team_id',
            'joinType' => 'INNER',
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['team_id'], 'Teams'));

        return $rules;
    }
}
