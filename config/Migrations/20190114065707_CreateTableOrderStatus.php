<?php
use Migrations\AbstractMigration;

class CreateTableOrderStatus extends AbstractMigration
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
        $table = $this->table('order_status');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 32
        ]);
        $table->create();
    }
}
