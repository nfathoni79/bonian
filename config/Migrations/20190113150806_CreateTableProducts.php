<?php
use Migrations\AbstractMigration;

class CreateTableProducts extends AbstractMigration
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
        $table = $this->table('products');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255
        ]);
        $table->addColumn('title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true
        ]);
        $table->addColumn('slug', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true
        ]);
        $table->addColumn('model', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true
        ]);
        $table->addColumn('code', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true
        ]);
        $table->addColumn('sku', 'string', [
            'default' => null,
            'limit' => 25,
            'null' => true
        ]);
        $table->addColumn('isbn', 'string', [
            'default' => null,
            'limit' => 25,
            'null' => true
        ]);
        $table->addColumn('qty', 'integer', [
            'default' => 1,
            'limit' => 6
        ]);
        $table->addColumn('product_stock_status_id', 'integer', [
            'default' => null,
            'limit' => 2,
            'null' => true
        ]);
        $table->addColumn('shipping', 'integer', [
            'default' => 1,
            'limit' => 1
        ]);
        $table->addColumn('price', 'decimal', [
            'default' => null,
            'precision'=>11,
            'scale'=>2
        ]);
        $table->addColumn('price_discount', 'decimal', [
            'default' => null,
            'precision'=>11,
            'scale'=>2
        ]);
        $table->addColumn('weight', 'float', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('product_weight_class_id', 'integer', [
            'default' => null,
            'limit' => 2,
            'null' => true
        ]);
        $table->addColumn('product_status_id', 'integer', [
            'default' => null,
            'limit' => 2
        ]);
        $table->addColumn('highlight', 'text', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('condition', 'text', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('profile', 'text', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('view', 'integer', [
            'default' => 0,
            'limit' => 2
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => 0,
            'null' => true
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => 0,
            'null' => true
        ]);
        $table->addIndex('product_status_id');
        $table->addForeignKey('product_status_id', 'product_statuses', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('product_stock_status_id');
        $table->addForeignKey('product_stock_status_id', 'product_stock_statuses', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('product_weight_class_id');
        $table->addForeignKey('product_weight_class_id', 'product_weight_classes', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}