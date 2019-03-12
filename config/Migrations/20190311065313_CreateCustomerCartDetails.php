<?php
use Migrations\AbstractMigration;

class CreateCustomerCartDetails extends AbstractMigration
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
        $table = $this->table('customer_cart_details');

        $table->addColumn('customer_cart_id', 'integer', [
            'null' => false,
            'limit' => 11,
//            'comment' => '1, active, 2 : expired'
        ]);
        $table->addColumn('qty', 'integer', [
            'null' => false,
            'limit' => 11,
        ]);
        $table->addColumn('product_id', 'integer', [
            'null' => false,
            'limit' => 11,
        ]);
        $table->addColumn('product_option_price_id', 'integer', [
            'null' => false,
            'limit' => 11,
        ]);
        $table->addColumn('product_option_stock_id', 'integer', [
            'null' => false,
            'limit' => 11,
        ]);
        $table->addColumn('price', 'float', [
            'null' => false,
        ]);
        $table->addColumn('add_price', 'float', [
            'null' => false,
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
        $table->addColumn('total', 'float', [
            'null' => false,
        ]);
        $table->addColumn('status', 'integer', [
            'null' => false,
            'limit' => 1,
            'comment' => '1 : available, 2 : expired, 3 : outoff stock, 4: deleted'
        ]);
        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'null' => false,
        ]);

        $table->addIndex('customer_cart_id');
        $table->addIndex('product_id');
        $table->addIndex('product_option_price_id');
        $table->addIndex('product_option_stock_id');
        $table->create();
    }
}
