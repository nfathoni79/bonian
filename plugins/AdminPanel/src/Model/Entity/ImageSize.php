<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImageSize Entity
 *
 * @property int $id
 * @property string $model
 * @property int|null $foreign_key
 * @property string $dimension
 * @property string $path
 * @property \Cake\I18n\FrozenTime $created
 */
class ImageSize extends Entity
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
        'model' => true,
        'foreign_key' => true,
        'dimension' => true,
        'path' => true,
        'created' => true
    ];
}
