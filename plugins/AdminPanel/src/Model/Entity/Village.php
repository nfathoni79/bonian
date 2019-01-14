<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Village Entity
 *
 * @property int $id
 * @property int $district_id
 * @property string $name
 *
 * @property \AdminPanel\Model\Entity\District $district
 * @property \AdminPanel\Model\Entity\CustomerAddress[] $customer_addresses
 */
class Village extends Entity
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
        'district_id' => true,
        'name' => true,
        'district' => true,
        'customer_addresses' => true
    ];
}
