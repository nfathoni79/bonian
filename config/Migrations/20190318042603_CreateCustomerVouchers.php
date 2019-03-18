<?php
use Migrations\AbstractMigration;

class CreateCustomerVouchers extends AbstractMigration
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

        $table->addColumn('customer_id', 'integer', [
            'null' => true,
            'limit' => 11,
            'default' => null
        ]);

        $table->addColumn('voucher_id', 'integer', [
            'null' => true,
            'limit' => 11,
            'default' => null
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null
        ]);

        $table->addIndex(['customer_id', 'voucher_id']);

        $table->create();
    }
}
