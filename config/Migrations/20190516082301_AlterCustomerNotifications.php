<?php
use Migrations\AbstractMigration;

class AlterCustomerNotifications extends AbstractMigration
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

        $table->addColumn('pass', 'string', [
            'default' => null,
            'limit' => 255,
            'after' => 'action',
            'null' => true
        ]);

        $table->addColumn('static_url', 'string', [
            'default' => null,
            'limit' => 255,
            'after' => 'pass',
            'null' => true
        ]);

        $table->addColumn('image_type', 'integer', [
            'default' => 1,
            'limit' => 4,
            'after' => 'static_url',
            'null' => true,
            'comment' => '1: absolute path, 2: full url with http'
        ]);

        $table->addColumn('image', 'string', [
            'default' => null,
            'limit' => 255,
            'after' => 'image_type',
            'null' => true
        ]);


        $table->update();
    }
}
