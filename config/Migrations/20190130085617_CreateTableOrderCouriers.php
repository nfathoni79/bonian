<?php
use Migrations\AbstractMigration;

class CreateTableOrderCouriers extends AbstractMigration
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
        $table = $this->table('order_couriers');
        $table->addColumn('order_courier_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('datetime', 'datetime', [
            'default' => null
        ]);
        $table->addColumn('description', 'text', [
            'default' => null
        ]);
        $table->addColumn('courier_status_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->addIndex('order_courier_id');
        $table->addForeignKey('order_courier_id', 'order_couriers', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('courier_status_id');
        $table->addForeignKey('courier_status_id', 'courier_statuses', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);

        $table->create();
    }
}
