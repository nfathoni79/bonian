<?php
use Migrations\AbstractMigration;

class AlterTableOrders3 extends AbstractMigration
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

        $table->addColumn('recipient_name', 'string', [
            'default' => null,
            'limit' => 50,
            'after' => 'address',
            'null' => true
        ]);
        $table->addColumn('recipient_phone', 'string', [
            'default' => null,
            'limit' => 50,
            'after' => 'recipient_name',
            'null' => true
        ]);
        $table->update();
    }
}
