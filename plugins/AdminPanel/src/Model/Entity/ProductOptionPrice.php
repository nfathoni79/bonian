<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductOptionPrice Entity
 *
 * @property int $id
 * @property int $product_id
 * @property string $sku
 * @property string $expired
 * @property float $price
 * @property int $idx
 *
 * @property \AdminPanel\Model\Entity\Product $product
 * @property \AdminPanel\Model\Entity\ProductOptionStock[] $product_option_stocks
 * @property \AdminPanel\Model\Entity\ProductOptionValueList[] $product_option_value_lists
 */
class ProductOptionPrice extends Entity
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
        'product_id' => true,
        'sku' => true,
        'expired' => true,
        'price' => true,
        'idx' => true,
        'product' => true,
        'product_option_stocks' => true,
        'product_option_value_lists' => true
    ];
}
