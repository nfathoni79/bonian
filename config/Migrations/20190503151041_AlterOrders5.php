<?php
use Migrations\AbstractMigration;

class AlterOrders5 extends AbstractMigration
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


        $table->addIndex(['invoice']);
        $table->addIndex(['payment_status']);

        $table->update();
    }
}
