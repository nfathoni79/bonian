<?php
use Migrations\AbstractMigration;

class AlterOrders9 extends AbstractMigration
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
        $table = $this->table('orders');


        $table->changeColumn('payment_status', 'integer', [
            'default' => 1,
            'limit' => 1,
            'null' => true,
            'comment' => '1: pending, 2: success, 3: failed, 4: expired, 5: refund, 6: cancel'
        ]);

        $table->update();
    }
}
