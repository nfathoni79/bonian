<?php
use Migrations\AbstractMigration;

class CreateTableCustomers extends AbstractMigration
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
        $table->addColumn('email', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true
        ]);
        $table->addColumn('password', 'string', [
            'default' => null,
            'limit' => 255,
        ]);
        $table->addColumn('first_name', 'string', [
            'default' => null,
            'limit' => 30,
        ]);
        $table->addColumn('last_name', 'string', [
            'default' => null,
            'limit' => 30,
        ]);
        $table->addColumn('phone', 'integer', [
            'default' => null,
            'limit' => 15,
        ]);
        $table->addColumn('dob', 'date', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('customer_group_id', 'integer', [
            'default' => null,
            'limit' => 1,
            'null' => true
        ]);
        $table->addColumn('customer_status_id', 'integer', [
            'default' => 1,
            'limit' => 1
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->addIndex('customer_group_id');
        $table->addForeignKey('customer_group_id', 'customer_groups', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('customer_status_id');
        $table->addForeignKey('customer_status_id', 'customer_statuses', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
