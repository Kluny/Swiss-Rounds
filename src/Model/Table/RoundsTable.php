<?php
namespace SwissRounds\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rounds Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Tournaments
 * @property \Cake\ORM\Association\HasMany $Matches
 *
 * @method \SwissRounds\Model\Entity\Round get($primaryKey, $options = [])
 * @method \SwissRounds\Model\Entity\Round newEntity($data = null, array $options = [])
 * @method \SwissRounds\Model\Entity\Round[] newEntities(array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Round|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SwissRounds\Model\Entity\Round patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Round[] patchEntities($entities, array $data, array $options = [])
 * @method \SwissRounds\Model\Entity\Round findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RoundsTable extends Table
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

        $this->table('rounds');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Tournaments', [
            'foreignKey' => 'tournament_id',
            'joinType' => 'INNER',
            'className' => 'SwissRounds.Tournaments'
        ]);
        $this->hasMany('Matches', [
            'foreignKey' => 'round_id',
            'className' => 'SwissRounds.Matches',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
