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
            'limit' => 11
        ]);


        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255
        ]);


        $table->addColumn('option_value_id', 'integer', [
            'default' => null,
            'limit' => 11
        ]);


        $table->addColumn('price', 'float', [
            'default' => 0,
            'comment' => 'additiona price from base price'
        ]);


        $table->addColumn('weight', 'integer', [
            'default' => null,
            'limit' => 5,
            'comment' => 'in gram additional weight from base wight'
        ]);


        $table->addColumn('stock', 'integer', [
            'default' => null,
            'limit' => 11
        ]);
        $table->addColumn('width', 'integer', [
            'default' => null,
            'limit' => 11
        ]);
        $table->addColumn('length', 'integer', [
            'default' => null,
            'limit' => 11
        ]);
        $table->addColumn('height', 'integer', [
            'default' => null,
            'limit' => 11
        ]);

        $table->addIndex('product_id');
        $table->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('option_value_id');
        $table->addForeignKey('option_value_id', 'option_values', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
