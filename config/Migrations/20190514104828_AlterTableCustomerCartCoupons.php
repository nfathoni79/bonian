<?php
use Migrations\AbstractMigration;

class AlterTableCustomerCartCoupons extends AbstractMigration
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
        $table->addColumn('product_id', 'integer', [
            'limit' => 11,
            'after' => 'product_coupon_id',
            'null' => false
        ]);
        $table->update();
    }
}
