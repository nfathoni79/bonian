<?php
use Migrations\AbstractSeed;

/**
 * CustomerNotificationTypes seed.
 */
class CustomerNotificationTypesSeed extends AbstractSeed
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
                'name' => 'Pesanan',
            ],
            [
                'id' => '2',
                'name' => 'Update',
            ],
            [
                'id' => '3',
                'name' => 'Promo',
            ],
        ];

        $table = $this->table('customer_notification_types');
        $table->insert($data)->save();
    }
}
