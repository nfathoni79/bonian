<?php
use Migrations\AbstractSeed;

/**
 * Groups seed.
 */
class GroupsSeed extends AbstractSeed
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
                'name' => 'Administrator',
                'created' => '2018-11-20 10:35:39',
                'modified' => '2018-11-20 10:35:39',
            ],
            [
                'id' => '2',
                'name' => 'Contributor',
                'created' => '2018-11-20 10:46:41',
                'modified' => '2018-11-20 10:46:41',
            ],
            [
                'id' => '5',
                'name' => 'tet lagi',
                'created' => '2018-11-22 16:56:58',
                'modified' => '2018-11-22 16:56:58',
            ],
        ];

        $table = $this->table('groups');
        $table->insert($data)->save();
    }
}
