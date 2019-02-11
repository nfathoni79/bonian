<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\RajaOngkirComponent;

/**
 * RajaOngkir command.
 * @property \AdminPanel\Model\Table\ProvincesTable $Provinces
 * @property \AdminPanel\Model\Table\CitiesTable $Cities
 * @property \AdminPanel\Model\Table\SubdistrictsTable $Subdistricts
 * @property \App\Controller\Component\RajaOngkirComponent $RajaOngkir
 */
class RajaOngkirCommand extends Command
{

    protected $RajaOngkir;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Provinces');
        $this->loadModel('AdminPanel.Cities');
        $this->loadModel('AdminPanel.Subdistricts');
        $this->RajaOngkir = new RajaOngkirComponent(new ComponentRegistry());
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser = parent::buildOptionParser($parser);

        $parser
            ->addOption('province', [
                'help' => 'grab all province from raja ongkir',
                'boolean' => true
            ])
            ->addOption('city', [
                'help' => 'grab all city from raja ongkir',
                'boolean' => true
            ])
            ->addOption('subdistrict', [
                'help' => 'grab all subdistrict from raja ongkir',
                'boolean' => true
            ]);

        return $parser;
    }


    protected function dumpProvinces()
    {
        $provinces = $this->RajaOngkir->getProvince();
        if ($provinces['rajaongkir']['status']['code'] == 200) {
            $this->Provinces->getConnection()->begin();
            foreach($provinces['rajaongkir']['results'] as $val) {
                $update = $this->Provinces->find()
                    ->where(['id' => $val['province_id']])
                    ->first();
                $update = isset($update) ? $update : $this->Provinces->newEntity();

                $update->set('id', $val['province_id'])
                    ->set('name', $val['province']);

                $this->Provinces->save($update);
            }

            $this->Provinces->getConnection()->commit();
        }
    }

    protected function dumpCities()
    {
        $provinces = $this->RajaOngkir->getCity();
        if ($provinces['rajaongkir']['status']['code'] == 200) {
            $this->Cities->getConnection()->begin();
            foreach($provinces['rajaongkir']['results'] as $val) {
                $update = $this->Cities->find()
                    ->where(['id' => $val['city_id']])
                    ->first();
                $update = isset($update) ? $update : $this->Cities->newEntity();

                $update->set('id', $val['city_id'])
                    ->set('name', $val['city_name'])
                    ->set('province_id', $val['province_id'])
                    ->set('type', $val['type'])
                    ->set('postal_code', $val['postal_code']);

                $this->Cities->save($update);
            }

            $this->Cities->getConnection()->commit();
        }
    }


    protected function dumpSubdistrict()
    {
        $cities = $this->Cities->find()->all();
        /**
         * @var \AdminPanel\Model\Entity\City $cities
         */
        foreach($cities as $city) {

            $get_city = $this->RajaOngkir->getSubdistrict($city->get('id'));
            if ($get_city['rajaongkir']['status']['code'] == 200) {
                $this->Subdistricts->getConnection()->begin();
                foreach($get_city['rajaongkir']['results'] as $val) {
                    $update = $this->Subdistricts->find()
                        ->where(['id' => $val['subdistrict_id']])
                        ->first();
                    $update = isset($update) ? $update : $this->Subdistricts->newEntity();
                    $update->set('id', $val['subdistrict_id'])
                        ->set('city_id', $val['city_id'])
                        ->set('name', $val['subdistrict_name']);
                    $this->Subdistricts->save($update);
                }
                $this->Subdistricts->getConnection()->commit();
            }
        }
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        if ($args->getOption('province')) {
            $this->dumpProvinces();
        } else if ($args->getOption('city')) {
            $this->dumpCities();
        } else if ($args->getOption('subdistrict')) {
            $this->dumpSubdistrict();
        }
    }
}
