<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * PriceSettingDetail Entity
 *
 * @property int $id
 * @property int $price_setting_id
 * @property string $sku
 * @property int|null $product_id
 * @property int|null $product_option_price_id
 * @property string $type
 * @property float $price
 * @property int $status
 *
 * @property \AdminPanel\Model\Entity\PriceSetting $price_setting
 * @property \AdminPanel\Model\Entity\Product $product
 * @property \AdminPanel\Model\Entity\ProductOptionPrice $product_option_price
 */
class PriceSettingDetail extends Entity
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
        'price_setting_id' => true,
        'sku' => true,
        'product_id' => true,
        'product_option_price_id' => true,
        'type' => true,
        'price' => true,
        'status' => true,
        'price_setting' => true,
        'product' => true,
        'product_option_price' => true
    ];
}
