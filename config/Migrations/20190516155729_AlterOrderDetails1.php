<?php
use Migrations\AbstractMigration;

class AlterOrderDetails1 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('order_details');

        $table->addColumn('shipping_etd', 'string', [
            'default' => null,
            'limit' => 50,
            'after' => 'shipping_cost',
            'null' => true
        ]);


        $table->update();
    }
}
