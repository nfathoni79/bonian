<?php
use Migrations\AbstractMigration;

class CreateTableProductOptionValues extends AbstractMigration
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
        $table = $this->table('product_option_values');
        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'limit' => 9,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true
        ]);
        $table->addColumn('option_value_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('price', 'decimal', [
            'default' => null,
            'precision'=>11,
            'scale'=>2,
            'null' => true
        ]);
        $table->addColumn('weight', 'integer', [
            'default' => null,
            'limit' => 5,
            'null' => true
        ]);
        $table->addColumn('stock', 'integer', [
            'default' => 0,
            'limit' => 5
        ]);
        $table->addIndex('product_id');
        $table->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('option_value_id');
        $table->addForeignKey('option_value_id', 'option_values', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
