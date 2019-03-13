<?php
namespace AdminPanel\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
/**
 * Customer Entity
 *
 * @property int $id
 * @property string $reffcode
 * @property int $refferal_customer_id
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property \Cake\I18n\FrozenDate $dob
 * @property int|null $customer_group_id
 * @property int|null $customer_status_id
 * @property int $is_verified
 * @property string $platforrm
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \AdminPanel\Model\Entity\RefferalCustomer $refferal_customer
 * @property \AdminPanel\Model\Entity\CustomerGroup $customer_group
 * @property \AdminPanel\Model\Entity\CustomerStatus $customer_status
 * @property \AdminPanel\Model\Entity\ChatDetail[] $chat_details
 * @property \AdminPanel\Model\Entity\CustomerAddrese[] $customer_addreses
 * @property \AdminPanel\Model\Entity\CustomerBalance[] $customer_balances
 * @property \AdminPanel\Model\Entity\CustomerBuyGroupDetail[] $customer_buy_group_details
 * @property \AdminPanel\Model\Entity\CustomerBuyGroup[] $customer_buy_groups
 * @property \AdminPanel\Model\Entity\CustomerLogBrowsing[] $customer_log_browsings
 * @property \AdminPanel\Model\Entity\CustomerMutationAmount[] $customer_mutation_amounts
 * @property \AdminPanel\Model\Entity\CustomerMutationPoint[] $customer_mutation_points
 * @property \AdminPanel\Model\Entity\CustomerToken[] $customer_tokens
 * @property \AdminPanel\Model\Entity\CustomerVirtualAccount[] $customer_virtual_account
 * @property \AdminPanel\Model\Entity\Generation[] $generations
 * @property \AdminPanel\Model\Entity\Order[] $orders
 */
class Customer extends Entity
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
        'reffcode' => true,
        'refferal_customer_id' => true,
        'email' => true,
        'password' => true,
        'username' => true,
        'first_name' => true,
        'last_name' => true,
        'phone' => true,
        'dob' => true,
        'customer_group_id' => true,
        'customer_status_id' => true,
        'is_verified' => true,
        'platforrm' => true,
        'created' => true,
        'modified' => true,
        'refferal_customer' => true,
        'customer_group' => true,
        'customer_status' => true,
        'chat_details' => true,
        'gender' => true,
        'avatar' => true,
        'customer_addreses' => true,
        'customer_balances' => true,
        'customer_buy_group_details' => true,
        'customer_buy_groups' => true,
        'customer_log_browsings' => true,
        'customer_mutation_amounts' => true,
        'customer_mutation_points' => true,
        'customer_tokens' => true,
        'customer_virtual_account' => true,
        'generations' => true,
        'orders' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
