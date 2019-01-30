<?php

use Migrations\AbstractSeed;

class SortSeed extends AbstractSeed
{
    public function run()
    {
        $this->call('AcosSeed');
        $this->call('ArosSeed');
        $this->call('ArosAcosSeed');
        $this->call('ProvincesSeed');
        $this->call('RegenciesSeed');
        $this->call('DistrictsSeed');
        $this->call('VillagesSeed');
        $this->call('GroupsSeed');
        $this->call('CustomerGroupsSeed');
        $this->call('CustomerStatusesSeed');
        $this->call('OptionTypesSeed');
        $this->call('OrderStatusSeed');
        $this->call('ProductStatusesSeed');
        $this->call('ProductStockStatusesSeed');
        $this->call('ProductWeightClassesSeed');
        $this->call('UsersSeed');
        $this->call('UserStatusSeed');
        $this->call('ProductCategoriesSeed');
        $this->call('CouriersSeed');
        $this->call('CourierStatusesSeed');

    }
}