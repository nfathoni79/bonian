<?php
use Migrations\AbstractMigration;

class CreateTableCustomerCartCoupons extends AbstractMigration
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
        $table = $this->table('customer_cart_coupons');
        $table->addColumn('customer_cart_id', 'integer', [
            'null' => false,
            'limit' => 11
        ]);
        $table->addColumn('product_coupon_id', 'integer', [
            'null' => false,
            'limit' => 11
        ]);
        $table->addIndex(['customer_cart_id']);
        $table->addIndex(['product_coupon_id']);
        $table->create();
    }
}
