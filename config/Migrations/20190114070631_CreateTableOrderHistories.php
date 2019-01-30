<?php
use Migrations\AbstractMigration;

class CreateTableOrderHistories extends AbstractMigration
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
        $table = $this->table('order_histories');
        $table->addColumn('order_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('order_status_id', 'integer', [
            'default' => null,
            'limit' => 3
        ]);
        $table->addColumn('notify', 'integer', [
            'default' => 1,
            'limit' => 1
        ]);
        $table->addColumn('desciption', 'text', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->addIndex('order_id');
        $table->addForeignKey('order_id', 'orders', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('order_status_id');
        $table->addForeignKey('order_status_id', 'order_status', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
