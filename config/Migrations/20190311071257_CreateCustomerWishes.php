<?php
use Migrations\AbstractMigration;

class CreateCustomerWishes extends AbstractMigration
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
        $table = $this->table('customer_wishes');

        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('price', 'float', [
            'default' => 0,
            'null' => true
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null
        ]);

        $table->addColumn('modified', 'datetime', [
            'default' => null
        ]);

        $table->addIndex(['product_id', 'customer_id']);

        $table->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addForeignKey('customer_id', 'customers', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);


        $table->create();
    }
}
