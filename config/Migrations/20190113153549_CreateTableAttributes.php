<?php
use Migrations\AbstractMigration;

class CreateTableAttributes extends AbstractMigration
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
        $table = $this->table('attributes');
        $table->addColumn('product_categories_id', 'integer', [
            'default' => null,
            'limit' => 5
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 50
        ]);
        $table->addColumn('description', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true
        ]);
//        $table->addIndex('product_categories_id');
//        $table->addForeignKey('product_categories_id', 'product_categories', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
