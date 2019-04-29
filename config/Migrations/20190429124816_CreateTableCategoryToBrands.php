<?php
use Migrations\AbstractMigration;

class CreateTableCategoryToBrands extends AbstractMigration
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
        $table = $this->table('category_to_brands');

        $table->addColumn('product_category_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);

        $table->addColumn('brand_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
        ]);

        $table->addIndex(['product_category_id']);
        $table->addIndex(['brand_id']);


        $table->create();
    }
}
