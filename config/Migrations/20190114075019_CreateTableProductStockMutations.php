<?php
use Migrations\AbstractMigration;

class CreateTableProductStockMutations extends AbstractMigration
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
        $table = $this->table('product_stock_mutations');
        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('product_option_values_id', 'integer', [
            'default' => null,
            'limit' => 9,
            'null' => true
        ]);
        $table->addColumn('product_stock_mutation_type_id', 'integer', [
            'default' => null,
            'limit' => 3
        ]);
        $table->addColumn('amount', 'decimal', [
            'default' => null,
            'precision'=>11,
            'scale'=>2
        ]);
        $table->addColumn('balance', 'decimal', [
            'default' => null,
            'precision'=>11,
            'scale'=>2
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->addIndex('product_option_values_id');
        $table->addForeignKey('product_option_values_id', 'product_option_values', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('product_id');
        $table->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('product_stock_mutation_type_id');
        $table->addForeignKey('product_stock_mutation_type_id', 'product_stock_mutation_types', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
