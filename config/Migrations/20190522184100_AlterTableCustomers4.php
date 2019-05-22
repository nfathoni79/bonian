<?php
use Migrations\AbstractMigration;

class AlterTableCustomers4 extends AbstractMigration
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
        $table = $this->table('customers');
        $table->addColumn('is_email_verified', 'boolean', [
            'default' => 0,
            'after' => 'is_verified',
            'null' => false
        ]);
        $table->update();
    }
}
