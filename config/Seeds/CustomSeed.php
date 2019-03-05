<?php

use Migrations\AbstractSeed;

class CustomSeed extends AbstractSeed
{
    public function run()
    {
         $this->call('AttributesSeed'); 
         $this->call('BranchesSeed'); 

    }
}