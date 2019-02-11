<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Option Entity
 *
 * @property int $id
 * @property int $option_type_id
 * @property string $name
 * @property int $sort_order
 *
 * @property \AdminPanel\Model\Entity\OptionType $option_type
 * @property \AdminPanel\Model\Entity\OptionValue[] $option_values
 */
class Option extends Entity
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
        'option_type_id' => true,
        'name' => true,
        'sort_order' => true,
        'option_type' => true,
        'option_values' => true
    ];
}
