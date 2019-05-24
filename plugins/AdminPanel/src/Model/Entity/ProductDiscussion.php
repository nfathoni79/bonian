<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductDiscussion Entity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $lft
 * @property int $rght
 * @property int $product_id
 * @property int $customer_id
 * @property string|null $comment
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \AdminPanel\Model\Entity\ParentProductDiscussion $parent_product_discussion
 * @property \AdminPanel\Model\Entity\Product $product
 * @property \AdminPanel\Model\Entity\Customer $customer
 * @property \AdminPanel\Model\Entity\ChildProductDiscussion[] $child_product_discussions
 */
class ProductDiscussion extends Entity
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
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'product_id' => true,
        'customer_id' => true,
        'to_customer' => true,
        'user_id' => true,
        'is_admin' => true,
        'comment' => true,
        'read' => true,
        'created' => true,
        'parent_product_discussion' => true,
        'product' => true,
        'customer' => true,
        'child_product_discussions' => true
    ];
}
