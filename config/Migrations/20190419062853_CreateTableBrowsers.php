<?php
use Migrations\AbstractMigration;

class CreateTableBrowsers extends AbstractMigration
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
        $table = $this->table('browsers');

        $table->addColumn('bid', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 64,
        ]);

        $table->addColumn('user_agent', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 255,
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addIndex(['bid'], ['unique' => true]);

        $table->create();
    }
}
