<?php
use Migrations\AbstractMigration;

class AlterOrderDetailProducts extends AbstractMigration
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

        $table->addColumn('product_option_price_id', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11,
        ]);

        $table->addColumn('product_option_stock_id', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11,
        ]);

        $table->addColumn('in_flashsale', 'boolean', [
            'null' => false,
            'signed' => false,
            'default' => 0,
        ]);
        $table->addColumn('in_groupsale', 'boolean', [
            'null' => false,
            'signed' => false,
            'default' => 0,
        ]);

        $table->addIndex(['product_option_price_id', 'product_option_stock_id']);

        $table->addForeignKey('product_option_price_id', 'product_option_prices', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addForeignKey('product_option_stock_id', 'product_option_stocks', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);


        $table->update();
    }
}
