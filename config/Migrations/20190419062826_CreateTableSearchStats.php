<?php
use Migrations\AbstractMigration;

class CreateTableSearchStats extends AbstractMigration
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
        $table->addColumn('search_term_id', 'integer', [
            'null' => false,
            'limit' => 11,
        ]);
        $table->addColumn('browser_id', 'integer', [
            'null' => false,
            'limit' => 11,
        ]);
        $table->addColumn('customer_id', 'integer', [
            'null' => false,
            'limit' => 11,
        ]);
        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);
        $table->addIndex('search_term_id');
        $table->addIndex('browser_id');
        $table->addIndex('customer_id');
        $table->create();
    }

}
