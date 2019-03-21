<?php
use Migrations\AbstractMigration;

class AlterCustomerCarts extends AbstractMigration
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
        $table->changeColumn('status', 'integer', [
            'null' => false,
            'limit' => 1,
            'comment' => '1, active, 2 : expired, 3: deleted'
        ]);

        $table->update();
    }
}
