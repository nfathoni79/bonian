<?php
use Migrations\AbstractSeed;

/**
 * Couriers seed.
 */
class CouriersSeed extends AbstractSeed
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
                'name' => 'JNE',
            ],
            [
                'id' => '2',
                'name' => 'JNT',
            ],
            [
                'id' => '3',
                'name' => 'Go Send',
            ],
        ];

        $table = $this->table('couriers');
        $table->insert($data)->save();
    }
}
