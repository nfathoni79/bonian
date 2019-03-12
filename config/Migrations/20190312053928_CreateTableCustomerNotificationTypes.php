<?php
use Migrations\AbstractMigration;

class CreateTableCustomerNotificationTypes extends AbstractMigration
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
        $table = $this->table('customer_notification_types');
        $table->addColumn('name', 'string', [
            'null' => false,
            'limit' => 150,
        ]);
        $table->create();
    }
}
