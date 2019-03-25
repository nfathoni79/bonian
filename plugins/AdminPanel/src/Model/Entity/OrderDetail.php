<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderDetail Entity
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $branch_id
 * @property int|null $courrier_id
 * @property string|null $awb
 * @property int|null $province_id
 * @property int|null $city_id
 * @property int|null $subdistrict_id
 * @property float|null $product_price
 * @property string|null $shipping_code
 * @property string|null $shipping_service
 * @property int|null $shipping_weight
 * @property float|null $shipping_cost
 * @property float|null $total
 * @property int|null $order_status_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \AdminPanel\Model\Entity\Order $order
 * @property \AdminPanel\Model\Entity\Branch $branch
 * @property \AdminPanel\Model\Entity\Courrier $courrier
 * @property \AdminPanel\Model\Entity\Province $province
 * @property \AdminPanel\Model\Entity\City $city
 * @property \AdminPanel\Model\Entity\Subdistrict $subdistrict
 * @property \AdminPanel\Model\Entity\OrderStatus $order_status
 * @property \AdminPanel\Model\Entity\Chat[] $chats
 * @property \AdminPanel\Model\Entity\OrderDetailProduct[] $order_detail_products
 * @property \AdminPanel\Model\Entity\OrderShippingDetail[] $order_shipping_details
 */
class OrderDetail extends Entity
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
        'order_id' => true,
        'branch_id' => true,
        'courrier_id' => true,
        'awb' => true,
        'province_id' => true,
        'city_id' => true,
        'subdistrict_id' => true,
        'product_price' => true,
        'shipping_code' => true,
        'shipping_service' => true,
        'shipping_weight' => true,
        'shipping_cost' => true,
        'total' => true,
        'order_status_id' => true,
        'created' => true,
        'modified' => true,
        'order' => true,
        'branch' => true,
        'courrier' => true,
        'province' => true,
        'city' => true,
        'subdistrict' => true,
        'order_status' => true,
        'chats' => true,
        'order_detail_products' => true,
        'order_shipping_details' => true
    ];
}
