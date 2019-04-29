<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * CategoryToBrand Entity
 *
 * @property int $id
 * @property int|null $product_category_id
 * @property int|null $brand_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \AdminPanel\Model\Entity\ProductCategory $product_category
 * @property \AdminPanel\Model\Entity\Brand $brand
 */
class CategoryToBrand extends Entity
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
        'product_category_id' => true,
        'brand_id' => true,
        'created' => true,
        'product_category' => true,
        'brand' => true
    ];
}
