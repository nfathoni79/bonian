<?php
use Migrations\AbstractMigration;

class AlterSearchStats extends AbstractMigration
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
        $table = $this->table('search_stats');

        $table->changeColumn('browser_id', 'integer', [
            'null' => true,
            'default' => null,
            'limit' => 11,
        ]);
        $table->changeColumn('customer_id', 'integer', [
            'null' => true,
            'default' => null,
            'limit' => 11,
        ]);

        $table->update();
    }
}
