<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * District Entity
 *
 * @property int $id
 * @property int $regency_id
 * @property string $name
 *
 * @property \AdminPanel\Model\Entity\Regency $regency
 * @property \AdminPanel\Model\Entity\CustomerAddress[] $customer_addresses
 * @property \AdminPanel\Model\Entity\Village[] $villages
 */
class District extends Entity
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
        'regency_id' => true,
        'name' => true,
        'regency' => true,
        'customer_addresses' => true,
        'villages' => true
    ];
}
