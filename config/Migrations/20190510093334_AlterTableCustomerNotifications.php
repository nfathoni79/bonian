<?php
use Migrations\AbstractMigration;

class AlterTableCustomerNotifications extends AbstractMigration
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

        if ($table->hasColumn('content')) {
            $table->removeColumn('content');
        }
        if ($table->hasColumn('status')) {
            $table->removeColumn('status');
        }

        $table->addColumn('message', 'text', [
            'null' => true,
            'after' => 'customer_notification_type_id',
        ]);
        $table->addColumn('model', 'string', [
            'default' => null,
            'limit' => 255,
            'after' => 'message',
            'null' => true
        ]);

        $table->addColumn('foreign_key', 'integer', [
            'default' => null,
            'limit' => 11,
            'after' => 'model',
            'null' => true
        ]);


        $table->addColumn('controller', 'string', [
            'default' => null,
            'limit' => 50,
            'after' => 'foreign_key',
            'null' => true
        ]);


        $table->addColumn('action', 'string', [
            'default' => null,
            'limit' => 50,
            'after' => 'controller',
            'null' => true
        ]);


        $table->addColumn('is_read', 'boolean', [
            'default' => false,
            'after' => 'action',
            'null' => true
        ]);

        $table->addColumn('template', 'string', [
            'default' => null,
            'limit' => 50,
            'after' => 'is_read',
            'null' => true,
            'comment' => 'email_template'
        ]);


        $table->update();
    }
}
