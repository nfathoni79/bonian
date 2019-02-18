<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Branch Entity
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property int $provice_id
 * @property int $city_id
 * @property int $subdistrict_id
 * @property float $latitude
 * @property float $longitude
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \AdminPanel\Model\Entity\Province $province
 * @property \AdminPanel\Model\Entity\City $city
 * @property \AdminPanel\Model\Entity\Subdistrict $subdistrict
 * @property \AdminPanel\Model\Entity\OrderDetail[] $order_details
 * @property \AdminPanel\Model\Entity\ProductBranch[] $product_branches
 * @property \AdminPanel\Model\Entity\ProductOptionValue[] $product_option_values
 * @property \AdminPanel\Model\Entity\ProductStockMutation[] $product_stock_mutations
 * @property \AdminPanel\Model\Entity\User[] $users
 */
class Branch extends Entity
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
        'name' => true,
        'address' => true,
        'phone' => true,
        'provice_id' => true,
        'city_id' => true,
        'subdistrict_id' => true,
        'latitude' => true,
        'longitude' => true,
        'created' => true,
        'modified' => true,
        'province' => true,
        'city' => true,
        'subdistrict' => true,
        'order_details' => true,
        'product_branches' => true,
        'product_option_values' => true,
        'product_stock_mutations' => true,
        'users' => true
    ];
}
