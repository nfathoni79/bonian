<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * AttributeGroup Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $sort_order
 *
 * @property \AdminPanel\Model\Entity\Attribute[] $attributes
 */
class AttributeGroup extends Entity
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
        'description' => true,
        'sort_order' => true,
        'attributes' => true
    ];
}
