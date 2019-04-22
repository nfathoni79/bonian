<?php
use Migrations\AbstractMigration;

class AlterSearchCategories extends AbstractMigration
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

        $table->addColumn('browser_id', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11,
            'after' => 'product_category_id'
        ]);

        $table->addIndex(['browser_id']);

        $table->update();
    }
}
