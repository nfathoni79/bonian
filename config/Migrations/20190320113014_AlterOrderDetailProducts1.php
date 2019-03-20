<?php
use Migrations\AbstractMigration;

class AlterOrderDetailProducts1 extends AbstractMigration
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
        $table = $this->table('order_detail_products');

        $table->changeColumn('order_detail_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);

        $table->changeColumn('product_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);

        $table->changeColumn('product_option_value_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);

        $table->changeColumn('qty', 'integer', [
            'default' => 1,
            'limit' => 11,
            'null' => true
        ]);

        $table->changeColumn('price', 'float', [
            'default' => 0,
            'limit' => 11,
            'null' => true
        ]);

        $table->changeColumn('total', 'float', [
            'default' => 0,
            'limit' => 11,
            'null' => true
        ]);


        $table->update();
    }
}
