<?php
use Migrations\AbstractMigration;

class CreateTableSearchTerms extends AbstractMigration
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
        $table = $this->table('search_terms');

        $table->addColumn('words', 'string', [
            'null' => false,
            'limit' => 255,
        ]);

        $table->addColumn('hits', 'integer', [
            'null' => false,
            'limit' => 11,
        ]);
        $table->addColumn('match', 'boolean', [
            'default' => false,
            'null' => false,
        ]);

        $table->create();
    }
}
