<?php
use Migrations\AbstractMigration;

class CreateTableCustomerShareProducts extends AbstractMigration
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
        $table = $this->table('customer_share_products');

        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);

        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);

        $table->addColumn('order_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);

        $table->addColumn('percentage', 'float', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addIndex(['customer_id']);
        $table->addIndex(['product_id']);
        $table->addIndex(['order_id']);


        $table->create();
    }
}
