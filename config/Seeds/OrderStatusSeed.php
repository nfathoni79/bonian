<?php
use Migrations\AbstractSeed;

/**
 * OrderStatus seed.
 */
class OrderStatusSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'name' => 'Pending',
            ],
            [
                'id' => '2',
                'name' => 'Processing',
            ],
            [
                'id' => '3',
                'name' => 'Shipped',
            ],
            [
                'id' => '4',
                'name' => 'Complete',
            ],
            [
                'id' => '5',
                'name' => 'Canceled',
            ],
            [
                'id' => '6',
                'name' => 'Denied',
            ],
            [
                'id' => '7',
                'name' => 'Canceled Reversal',
            ],
            [
                'id' => '10',
                'name' => 'Failed',
            ],
            [
                'id' => '11',
                'name' => 'Refunded',
            ],
            [
                'id' => '12',
                'name' => 'Reversed',
            ],
            [
                'id' => '13',
                'name' => 'Chargeback',
            ],
            [
                'id' => '14',
                'name' => 'Expired',
            ],
            [
                'id' => '15',
                'name' => 'Processed',
            ],
            [
                'id' => '16',
                'name' => 'Voided',
            ],
        ];

        $table = $this->table('order_status');
        $table->insert($data)->save();
    }
}
