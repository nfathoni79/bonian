<?php
use Migrations\AbstractSeed;

/**
 * UserStatus seed.
 */
class UserStatusSeed extends AbstractSeed
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
                'name' => 'Active'
            ],
            [
                'id' => '2',
                'name' => 'In Active'
            ],
        ];

        $table = $this->table('user_status');
        $table->insert($data)->save();
    }
}
