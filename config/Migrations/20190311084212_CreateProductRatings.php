<?php
use Migrations\AbstractMigration;

class CreateProductRatings extends AbstractMigration
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
        $table = $this->table('product_ratings');

        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('rating', 'integer', [
            'default' => 1,
            'limit' => 1,
            'null' => true
        ]);

        $table->addColumn('comment', 'text', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null
        ]);

        $table->addColumn('modified', 'datetime', [
            'default' => null
        ]);

        $table->addIndex(['product_id', 'customer_id']);

        $table->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addForeignKey('customer_id', 'customers', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);


        $table->create();
    }
}
