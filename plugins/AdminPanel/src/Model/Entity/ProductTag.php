<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductTag Entity
 *
 * @property int $id
 * @property int $product_id
 * @property int $tag_id
 *
 * @property \AdminPanel\Model\Entity\Product $product
 * @property \AdminPanel\Model\Entity\Tag $tag
 */
class ProductTag extends Entity
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
        'tag_id' => true,
        'product' => true,
        'tag' => true
    ];
}
