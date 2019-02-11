<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Client;
use Cake\Core\Configure;

/**
 * RajaOngkir component
 */
class RajaOngkirComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    protected $key = null;
    protected $defaultRequest = [];

    public function initialize(array $config)
    {
        parent::initialize($config);
        if (array_key_exists('key', $config)) {
            $this->key = $config['key'];
        } else {
            $this->key = Configure::read('Rajaongkir.key');
        }

        $hosts = parse_url(Configure::read('Rajaongkir.url'));


        $this->defaultRequest = [
            'headers' => [
                'key' => $this->key
            ]
        ];

        $this->defaultRequest += $hosts;


    }

    protected function getbase()
    {
        return $this->defaultRequest['path'];
    }

    protected function setPath($url = null)
    {
        return rtrim($this->getbase(), '/') . $url;
    }

    public function getProvince($id = null)
    {
        $http = new Client($this->defaultRequest);
        $query = isset($id) ? ['id' => $id] : null;
        $response = $http->get($this->setPath('/province'), $query);
        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        }
    }

    public function getCity($province_id = null, $city_id = null)
    {
        $http = new Client($this->defaultRequest);
        $query = isset($province_id) || isset($city_id) ? ['province' => $province_id, 'id' => $city_id] : null;
        $response = $http->get($this->setPath('/city'), $query);
        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        }
    }

    public function getSubdistrict($city_id = null, $id = null)
    {
        $http = new Client($this->defaultRequest);
        $query = isset($city_id) || isset($id) ? ['city' => $city_id, 'id' => $id] : null;
        $response = $http->get($this->setPath('/subdistrict'), $query);
        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        }
    }
}
