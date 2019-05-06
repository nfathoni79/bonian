<?php
use Migrations\AbstractMigration;

class AlterTableOrders1 extends AbstractMigration
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

        $table->addColumn('order_type', 'integer', [
            'default' => 1,
            'null' => true,
            'limit' => 2,
            'comment' => '1: product, 2: digital product',
            'after' => 'invoice'
        ]);

        $table->addIndex(['order_type']);

        $table->update();
    }
}
