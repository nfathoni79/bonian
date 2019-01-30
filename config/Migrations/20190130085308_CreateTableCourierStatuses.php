<?php
use Migrations\AbstractMigration;

class CreateTableCourierStatuses extends AbstractMigration
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
        $table = $this->table('courier_statuses');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 15
        ]);
        $table->create();
    }
}
