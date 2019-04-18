<?php
use Migrations\AbstractMigration;

class AlterTableCustomerVoucher extends AbstractMigration
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
        $table = $this->table('customer_vouchers');
        $table->removeIndex(['customer_id', 'voucher_id']);
        $table->addIndex(['customer_id']);
        $table->update();
    }
}
