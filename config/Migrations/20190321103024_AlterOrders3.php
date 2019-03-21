<?php
use Migrations\AbstractMigration;

class AlterOrders3 extends AbstractMigration
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

        $table->addColumn('payment_status', 'integer', [
            'default' => 1,
            'limit' => 1,
            'null' => true,
            'after' => 'total',
            'comment' => '1: pending, 2: success, 3: failed'
        ]);

        $table->update();
    }
}
