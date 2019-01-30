<?php
use Migrations\AbstractSeed;

/**
 * CourierStatues seed.
 */
class CourierStatusesSeed extends AbstractSeed
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
                'name' => 'pickup',
            ],
            [
                'id' => '2',
                'name' => 'delivery',
            ],
            [
                'id' => '3',
                'name' => 'done',
            ],
        ];
        $table = $this->table('courier_statuses');
        $table->insert($data)->save();
    }
}
