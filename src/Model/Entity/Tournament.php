<?php
namespace SwissRounds\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tournament Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\Time $created
 *
 * @property \SwissRounds\Model\Entity\Round[] $rounds
 * @property \SwissRounds\Model\Entity\Team[] $teams
 */
class Tournament extends Entity
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
