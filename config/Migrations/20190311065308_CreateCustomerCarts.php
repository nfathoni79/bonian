<?php
use Migrations\AbstractMigration;

class CreateCustomerCarts extends AbstractMigration
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
        $table = $this->table('customer_carts');
        $table->addColumn('customer_id', 'integer', [
            'null' => false,
            'limit' => 11,
        ]);
        $table->addColumn('status', 'integer', [
            'null' => false,
            'limit' => 1,
            'comment' => '1, active, 2 : expired'
        ]);
        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'null' => false,
        ]);
        $table->create();
    }
}
