<?php
use Migrations\AbstractSeed;

/**
 * Provinces seed.
 */
class ProvincesSeed extends AbstractSeed
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
                'name' => 'ACEH',
            ],
            [
                'id' => '2',
                'name' => 'SUMATERA UTARA',
            ],
            [
                'id' => '3',
                'name' => 'SUMATERA BARAT',
            ],
            [
                'id' => '4',
                'name' => 'RIAU',
            ],
            [
                'id' => '5',
                'name' => 'JAMBI',
            ],
            [
                'id' => '6',
                'name' => 'SUMATERA SELATAN',
            ],
            [
                'id' => '7',
                'name' => 'BENGKULU',
            ],
            [
                'id' => '8',
                'name' => 'LAMPUNG',
            ],
            [
                'id' => '9',
                'name' => 'KEPULAUAN BANGKA BELITUNG',
            ],
            [
                'id' => '10',
                'name' => 'KEPULAUAN RIAU',
            ],
            [
                'id' => '11',
                'name' => 'DKI JAKARTA',
            ],
            [
                'id' => '12',
                'name' => 'JAWA BARAT',
            ],
            [
                'id' => '13',
                'name' => 'JAWA TENGAH',
            ],
            [
                'id' => '14',
                'name' => 'DI YOGYAKARTA',
            ],
            [
                'id' => '15',
                'name' => 'JAWA TIMUR',
            ],
            [
                'id' => '16',
                'name' => 'BANTEN',
            ],
            [
                'id' => '17',
                'name' => 'BALI',
            ],
            [
                'id' => '18',
                'name' => 'NUSA TENGGARA BARAT',
            ],
            [
                'id' => '19',
                'name' => 'NUSA TENGGARA TIMUR',
            ],
            [
                'id' => '20',
                'name' => 'KALIMANTAN BARAT',
            ],
            [
                'id' => '21',
                'name' => 'KALIMANTAN TENGAH',
            ],
            [
                'id' => '22',
                'name' => 'KALIMANTAN SELATAN',
            ],
            [
                'id' => '23',
                'name' => 'KALIMANTAN TIMUR',
            ],
            [
                'id' => '24',
                'name' => 'KALIMANTAN UTARA',
            ],
            [
                'id' => '25',
                'name' => 'SULAWESI UTARA',
            ],
            [
                'id' => '26',
                'name' => 'SULAWESI TENGAH',
            ],
            [
                'id' => '27',
                'name' => 'SULAWESI SELATAN',
            ],
            [
                'id' => '28',
                'name' => 'SULAWESI TENGGARA',
            ],
            [
                'id' => '29',
                'name' => 'GORONTALO',
            ],
            [
                'id' => '30',
                'name' => 'SULAWESI BARAT',
            ],
            [
                'id' => '31',
                'name' => 'MALUKU',
            ],
            [
                'id' => '32',
                'name' => 'MALUKU UTARA',
            ],
            [
                'id' => '33',
                'name' => 'PAPUA BARAT',
            ],
            [
                'id' => '34',
                'name' => 'PAPUA',
            ],
        ];

        $table = $this->table('provinces');
        $table->insert($data)->save();
    }
}
