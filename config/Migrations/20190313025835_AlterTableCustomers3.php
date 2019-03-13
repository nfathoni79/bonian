<?php
use Migrations\AbstractMigration;

class AlterTableCustomers3 extends AbstractMigration
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

        $table->addColumn('avatar', 'string', [
            'default' => 'avatar.jpg',
            'null' => true,
            'limit' => 150,
            'after' => 'gender',
        ]);
        $table->update();
    }
}
