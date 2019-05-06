<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $order_type
 * @property string $invoice
 * @property int $customer_id
 * @property int|null $province_id
 * @property int|null $city_id
 * @property int|null $subdistrict_id
 * @property string $address
 * @property int|null $voucher_id
 * @property int|null $product_promotion_id
 * @property int|null $use_point
 * @property float|null $gross_total
 * @property float $total
 * @property int|null $payment_status
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \AdminPanel\Model\Entity\Customer $customer
 * @property \AdminPanel\Model\Entity\Province $province
 * @property \AdminPanel\Model\Entity\City $city
 * @property \AdminPanel\Model\Entity\Subdistrict $subdistrict
 * @property \AdminPanel\Model\Entity\Voucher $voucher
 * @property \AdminPanel\Model\Entity\ProductPromotion $product_promotion
 * @property \AdminPanel\Model\Entity\OrderDetail[] $order_details
 * @property \AdminPanel\Model\Entity\Transaction[] $transactions
 * @property \AdminPanel\Model\Entity\OrderDigital[] $order_digitals
 */
class Order extends Entity
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
        'invoice' => true,
        'order_type' => true,
        'customer_id' => true,
        'province_id' => true,
        'city_id' => true,
        'subdistrict_id' => true,
        'address' => true,
        'voucher_id' => true,
        'product_promotion_id' => true,
        'use_point' => true,
        'gross_total' => true,
        'total' => true,
        'payment_status' => true,
        'created' => true,
        'customer' => true,
        'province' => true,
        'city' => true,
        'subdistrict' => true,
        'voucher' => true,
        'product_promotion' => true,
        'order_details' => true,
        'transactions' => true,
        'order_digitals' => true
    ];
}
