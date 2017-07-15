<?php
namespace SwissRounds\Model\Entity;

use Cake\ORM\Entity;

/**
 * Round Entity
 *
 * @property int $id
 * @property int $tournament_id
 * @property \Cake\I18n\Time $created
 *
 * @property \SwissRounds\Model\Entity\Tournament $tournament
 * @property \SwissRounds\Model\Entity\Match[] $matches
 */
class Round extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
