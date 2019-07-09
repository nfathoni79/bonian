<?php
use Migrations\AbstractMigration;

class AlterSearchCategories1 extends AbstractMigration
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
        $table = $this->table('search_categories');

        $table->addColumn('total', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => true,
            'after' => 'browser_id'
        ]);

        $table->update();
    }
}
