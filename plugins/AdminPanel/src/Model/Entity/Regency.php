<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Regency Entity
 *
 * @property int $id
 * @property int $province_id
 * @property string $name
 *
 * @property \AdminPanel\Model\Entity\Province $province
 * @property \AdminPanel\Model\Entity\CustomerAddress[] $customer_addresses
 * @property \AdminPanel\Model\Entity\District[] $districts
 */
class Regency extends Entity
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
        'province_id' => true,
        'name' => true,
        'province' => true,
        'customer_addresses' => true,
        'districts' => true
    ];
}
