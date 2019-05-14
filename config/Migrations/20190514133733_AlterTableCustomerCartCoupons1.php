<?php
use Migrations\AbstractMigration;

class AlterTableCustomerCartCoupons1 extends AbstractMigration
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
        $table->changeColumn('customer_cart_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);

        $table->addColumn('customer_id', 'integer', [
            'limit' => 11,
            'after' => 'customer_cart_id',
            'null' => true
        ]);
        $table->update();
    }
}
