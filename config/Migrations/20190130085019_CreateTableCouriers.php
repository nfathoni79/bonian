<?php
use Migrations\AbstractMigration;

class CreateTableCouriers extends AbstractMigration
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
        $table = $this->table('couriers');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 10
        ]);
        $table->create();
    }
}
