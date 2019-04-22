<?php
use Migrations\AbstractMigration;

class CreateSearchCategories extends AbstractMigration
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

        $table->addColumn('search_term_id', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11
        ]);

        $table->addColumn('product_category_id', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true
        ]);

        $table->addIndex(['search_term_id']);
        $table->addIndex(['product_category_id']);


        $table->create();
    }
}
