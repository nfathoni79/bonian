<?php
use Migrations\AbstractMigration;

class AlterTableCustomers1 extends AbstractMigration
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
        $table = $this->table('table_customers1');
        $table->update();
    }
}
