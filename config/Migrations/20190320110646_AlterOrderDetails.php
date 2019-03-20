<?php
use Migrations\AbstractMigration;

class AlterOrderDetails extends AbstractMigration
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

        $table->changeColumn('order_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->changeColumn('branch_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->changeColumn('courrier_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->changeColumn('awb', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true
        ]);
        $table->changeColumn('courrier_code', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => true
        ]);
        $table->changeColumn('origin_subdistrict_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->changeColumn('destination_subdistrict_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->changeColumn('origin_city_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->changeColumn('destination_city_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->changeColumn('product_price', 'float', [
            'default' => 0,
            'null' => true
        ]);
        $table->changeColumn('shipping_cost', 'float', [
            'default' => 0,
            'null' => true
        ]);
        $table->changeColumn('total', 'float', [
            'default' => 0,
            'null' => true
        ]);
        $table->changeColumn('order_status_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);




        $table->update();
    }
}
