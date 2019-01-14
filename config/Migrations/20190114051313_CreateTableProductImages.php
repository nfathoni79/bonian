<?php
use Migrations\AbstractMigration;

class CreateTableProductImages extends AbstractMigration
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
        $table = $this->table('product_images');
        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'limit' => 9,
            'null' => true
        ]);
        $table->addColumn('primary', 'integer', [
            'default' => null,
            'limit' => 1,
            'null' => true
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->addIndex('product_id');
        $table->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
