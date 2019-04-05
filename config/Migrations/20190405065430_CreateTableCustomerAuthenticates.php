<?php
use Migrations\AbstractMigration;

class CreateTableCustomerAuthenticates extends AbstractMigration
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
        $table = $this->table('customer_authenticates');

        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);

        $table->addColumn('token', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => true,
        ]);


        $table->addColumn('expired', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addIndex('customer_id');
        $table->addIndex('token');


        $table->create();
    }
}
