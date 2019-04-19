<?php
use Migrations\AbstractMigration;

class AlterSearchTermsFulltext extends AbstractMigration
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

        if (!$table->hasIndexByName('fulltext_index')) {
            $table->addIndex(['words'], ['type' => 'fulltext']);
        }

        $table->update();
    }
}
