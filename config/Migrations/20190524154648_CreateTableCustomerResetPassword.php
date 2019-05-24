<?php
use Migrations\AbstractMigration;

class CreateTableCustomerResetPassword extends AbstractMigration
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
        $table = $this->table('customer_reset_password');

        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);

        $table->addColumn('request_name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true,
        ]);

        $table->addColumn('request_type', 'integer', [
            'default' => 1,
            'limit' => 2,
            'null' => true,
            'comment' => '1: email, 2: phone'
        ]);

        $table->addColumn('otp', 'string', [
            'default' => null,
            'limit' => 10,
            'null' => true,
        ]);

        $table->addColumn('session_id', 'string', [
            'default' => null,
            'limit' => 64,
            'null' => true,
            'comment' => 'can use session_id or token random string'
        ]);

        $table->addColumn('status', 'integer', [
            'default' => 0,
            'limit' => 2,
            'null' => true,
            'comment' => '0: pending, 1: otp verified, 2: used/ finish'
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addIndex(['customer_id']);
        $table->addIndex(['request_name']);
        $table->addIndex(['request_type']);
        $table->addIndex(['otp']);
        $table->addIndex(['session_id']);
        $table->addIndex(['otp', 'session_id', 'status'], ['unique' => true]);



        $table->create();
    }
}
