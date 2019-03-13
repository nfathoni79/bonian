<?php
use Migrations\AbstractMigration;

class AlterTableCustomerBalance extends AbstractMigration
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
        $table = $this->table('customer_balances');

        $table->addColumn('modified_point', 'datetime', [
            'null' => false,
            'after' => 'modified',
        ]);
        $table->update();
    }
}
