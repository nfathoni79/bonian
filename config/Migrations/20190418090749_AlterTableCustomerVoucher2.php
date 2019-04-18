<?php
use Migrations\AbstractMigration;

class AlterTableCustomerVoucher2 extends AbstractMigration
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
        $table->addColumn('expired', 'datetime', [
            'default' => null,
            'after' => 'status',
            'comment' => 'berlaku expired hanya untuk vouchers type 1'
        ]);
        $table->update();
    }
}
