<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductOptionValueList Entity
 *
 * @property int $id
 * @property int|null $product_option_price_id
 * @property int|null $option_value_id
 *
 * @property \AdminPanel\Model\Entity\ProductOptionPrice $product_option_price
 * @property \AdminPanel\Model\Entity\OptionValue $option_value
 */
class ProductOptionValueList extends Entity
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
        'product_option_price_id' => true,
        'option_value_id' => true,
        'product_option_price' => true,
        'option_value' => true
    ];
}
