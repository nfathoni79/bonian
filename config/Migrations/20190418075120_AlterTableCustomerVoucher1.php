<?php
use Migrations\AbstractMigration;

class AlterTableCustomerVoucher1 extends AbstractMigration
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
        $table->changeColumn('status', 'integer', [
            'null' => true,
            'default' => 1,
            'comment' => '1 pending, 2 used	, 3 expired'
        ]);
        $table->update();
    }
}
