<?php
use Migrations\AbstractMigration;

class AlterTableCustomerNotifications1 extends AbstractMigration
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
        $table = $this->table('customer_notifications');
        $table->addColumn('title', 'string', [
            'default' => null,
            'limit' => 150,
            'after' => 'customer_notification_type_id',
            'null' => true
        ]);
        $table->update();
    }
}
