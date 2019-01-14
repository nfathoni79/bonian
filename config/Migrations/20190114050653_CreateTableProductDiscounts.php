<?php
use Migrations\AbstractMigration;

class CreateTableProductDiscounts extends AbstractMigration
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
        $table = $this->table('product_discounts');
        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('discount', 'integer', [
            'default' => null,
            'limit' => 3,
            'null' => true
        ]);
        $table->addColumn('date_start', 'date', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('date_end', 'date', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->addIndex('product_id');
        $table->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
