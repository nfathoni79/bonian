<?php
use Migrations\AbstractMigration;

class CreateTableOrderProducts extends AbstractMigration
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
        $table = $this->table('order_products');
        $table->addColumn('order_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('qty', 'integer', [
            'default' => null,
            'limit' => 3
        ]);
        $table->addColumn('price', 'decimal', [
            'default' => null,
            'precision'=>11,
            'scale'=>2
        ]);
        $table->addColumn('total', 'decimal', [
            'default' => null,
            'precision'=>11,
            'scale'=>2
        ]);
        $table->addIndex('order_id');
        $table->addForeignKey('order_id', 'orders', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('product_id');
        $table->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
