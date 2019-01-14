<?php
use Migrations\AbstractMigration;

class CreateTableOrderOptions extends AbstractMigration
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
        $table = $this->table('order_options');
        $table->addColumn('order_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('order_product_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('product_option_value_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addIndex('order_id');
        $table->addForeignKey('order_id', 'orders', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('order_product_id');
        $table->addForeignKey('order_product_id', 'order_products', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('product_option_value_id');
        $table->addForeignKey('product_option_value_id', 'product_option_values', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
