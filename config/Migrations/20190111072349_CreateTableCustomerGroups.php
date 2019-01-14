<?php
use Migrations\AbstractMigration;

class CreateTableCustomerGroups extends AbstractMigration
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
        $table = $this->table('customer_groups');
        $table->addColumn('group', 'string', [
            'default' => null,
            'limit' => 15,
        ]);
        $table->create();
    }
}
