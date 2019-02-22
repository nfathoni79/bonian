<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductOptionStock Entity
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $product_option_price_id
 * @property int|null $branch_id
 * @property int|null $weight
 * @property int|null $stock
 * @property int|null $width
 * @property int|null $length
 * @property int|null $height
 *
 * @property \AdminPanel\Model\Entity\Product $product
 * @property \AdminPanel\Model\Entity\ProductOptionPrice $product_option_price
 * @property \AdminPanel\Model\Entity\Branch $branch
 * @property \AdminPanel\Model\Entity\ProductStockMutation[] $product_stock_mutations
 */
class ProductOptionStock extends Entity
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
        'product_option_price_id' => true,
        'branch_id' => true,
        'weight' => true,
        'stock' => true,
        'width' => true,
        'length' => true,
        'height' => true,
        'product' => true,
        'product_option_price' => true,
        'branch' => true,
        'product_stock_mutations' => true
    ];
}
