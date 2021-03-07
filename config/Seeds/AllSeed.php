<?php

use Migrations\AbstractSeed;

class AllSeed extends AbstractSeed
{
    public function run()
    {
         $this->call('AcosSeed');
         $this->call('ArosAcosSeed');
         $this->call('ArosSeed');
         $this->call('AttributesSeed');
         $this->call('BrandsSeed');
         $this->call('CourriersSeed');
         $this->call('CustomerGroupsSeed');
         $this->call('CustomerMutationAmountTypesSeed');
         $this->call('CustomerMutationPointTypesSeed');
         $this->call('CustomerNotificationTypesSeed');
         $this->call('CustomerPointRatesSeed');
         $this->call('CustomerStatusesSeed');
         $this->call('DigitalsSeed');
         $this->call('GameWheelsSeed');
         $this->call('GroupsSeed');
         $this->call('OptionsSeed');
         $this->call('OptionTypesSeed');
         $this->call('OptionValuesSeed');
         $this->call('OrderStatusesSeed');
         $this->call('ProductCategoriesSeed');
         $this->call('ProductStatusesSeed');
         $this->call('ProductStockMutationTypesSeed');
         $this->call('ProductStockStatusesSeed');
         $this->call('ProductWarrantiesSeed');
         $this->call('ProductWeightClassesSeed');
         $this->call('ProvincesSeed');
         $this->call('TagsSeed');
         $this->call('UserStatusSeed');
         $this->call('CitiesSeed');
         $this->call('DigitalDetailsSeed');
         $this->call('ProductsSeed');
         $this->call('ProductTagsSeed');
         $this->call('ProductToCategoriesSeed');
         $this->call('ProductToCourriersSeed');
         $this->call('SubdistrictsSeed');
         $this->call('UsersSeed');
         $this->call('BranchesSeed');
         $this->call('ProductAttributesSeed');
         $this->call('ProductImagesSeed');
         $this->call('ProductOptionPricesSeed');
         $this->call('ProductOptionStocksSeed');
         $this->call('ProductOptionValueListsSeed');
         $this->call('ProductImageSizesSeed');
    }
}
