<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * OptionValue Entity
 *
 * @property int $id
 * @property int $option_id
 * @property string $name
 *
 * @property \AdminPanel\Model\Entity\Option $option
 * @property \AdminPanel\Model\Entity\ProductOptionValue[] $product_option_values
 */
class OptionValue extends Entity
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
        'option_id' => true,
        'name' => true,
        'option' => true,
        'product_option_values' => true
    ];
}
