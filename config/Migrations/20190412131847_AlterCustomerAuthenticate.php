<?php
use Migrations\AbstractMigration;

class AlterCustomerAuthenticate extends AbstractMigration
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

        $table->addColumn('bid', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 64,
            'after' => 'token'
        ]);

        $table->addColumn('browser', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 150,
            'after' => 'bid'
        ]);

        $table->addColumn('ip', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 15,
            'after' => 'browser'
        ]);

        $table->addIndex(['bid']);

        $table->update();
    }
}
