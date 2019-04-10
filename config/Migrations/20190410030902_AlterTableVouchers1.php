<?php
use Migrations\AbstractMigration;

class AlterTableVouchers1 extends AbstractMigration
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
        $table = $this->table('vouchers');
        $table->changeColumn('code_voucher', 'string', [
            'null' => false,
            'limit' => 15
        ]);
        $table->update();
    }
}
