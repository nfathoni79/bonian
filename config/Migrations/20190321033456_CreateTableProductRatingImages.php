<?php
use Migrations\AbstractMigration;

class CreateTableProductRatingImages extends AbstractMigration
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
        $table = $this->table('product_rating_images');

        $table->addColumn('product_rating_id', 'integer', [
            'default' => null,
            'limit' => 11
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => true
        ]);

        $table->addColumn('dir', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true
        ]);

        $table->addColumn('size', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);

        $table->addColumn('type', 'string', [
            'default' => null,
            'limit' => 150,
            'null' => true
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
        ]);

        $table->addIndex('product_rating_id');
        $table->addForeignKey('product_rating_id', 'product_ratings', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);

        $table->create();
    }
}
