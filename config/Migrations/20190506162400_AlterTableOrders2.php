<?php
use Migrations\AbstractMigration;

class AlterTableOrders2 extends AbstractMigration
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
        $table = $this->table('orders');
        $table->addColumn('discount_voucher', 'float', [
            'default' => 0,
            'after' => 'gross_total',
            'null' => true
        ]);
        $table->addColumn('discount_kupon', 'float', [
            'default' => 0,
            'after' => 'discount_voucher',
            'null' => true
        ]);
        $table->addColumn('product_coupon_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $table->addIndex(['product_coupon_id']);
        $table->update();
    }
}
