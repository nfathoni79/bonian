<?php
use Migrations\AbstractMigration;

class AlterTableCustomers2 extends AbstractMigration
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

        $table->addColumn('gender', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 1,
            'after' => 'dob',
        ]);
        $table->update();
    }
}
