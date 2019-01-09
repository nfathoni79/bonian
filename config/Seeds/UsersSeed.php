<?php
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
                'email' => 'admin@admin.com',
                'password' => '$2y$10$2ofDLxFoKRygwI6T0.SvOu5A/qugAeK69lBWVjrwQMfpfIe/TVPPi',
                'first_name' => 'admin',
                'last_name' => '',
                'group_id' => '1',
                'user_status_id' => '1',
                'created' => '2018-11-20 10:36:33',
                'modified' => '2018-11-22 17:09:07',
            ],
            [
                'id' => '2',
                'email' => 'info@ridwan.id',
                'password' => '$2y$10$TC0lgiqiNPaa8rYXUfGi8eNjdTsKhgJ9hWzesAQc0eahNeBN3S2OG',
                'first_name' => 'ridwan',
                'last_name' => '',
                'group_id' => '2',
                'user_status_id' => '1',
                'created' => '2018-11-20 10:47:01',
                'modified' => '2018-11-20 10:47:01',
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
