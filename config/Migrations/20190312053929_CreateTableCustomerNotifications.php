<?php
use Migrations\AbstractMigration;

class CreateTableCustomerNotifications extends AbstractMigration
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
        $table->addColumn('customer_id', 'integer', [
            'null' => false,
            'limit' => 11
        ]);
        $table->addColumn('customer_notification_type_id', 'integer', [
            'null' => false,
            'limit' => 1
        ]);
        $table->addColumn('content', 'text', [
            'null' => true,
        ]);
        $table->addColumn('status', 'integer', [
            'default' => 0,
            'null' => true,
            'limit' => 1,
            'comment' => '0 : unred, 1 read',
        ]);
        $table->addColumn('created', 'datetime', [
            'null' => true,
        ]);
        $table->addColumn('modified', 'datetime', [
            'null' => true,
        ]);
        $table->addIndex(['customer_id', 'customer_notification_type_id']);

        $table->addForeignKey('customer_id', 'customers', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addForeignKey('customer_notification_type_id', 'customer_notification_types', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
