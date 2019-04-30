<?php
use Migrations\AbstractMigration;

class CreateTableProductDiscustions extends AbstractMigration
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
        $table = $this->table('product_discussions');
        $table->addColumn('parent_id', 'integer', [
            'default' => null,
            'after' => 'product_category_id',
            'null' => true,
            'limit' => 5
        ]);
        $table->addColumn('lft', 'integer', [
            'after' => 'parent_id',
            'null' => false,
            'limit' => 5
        ]);
        $table->addColumn('rght', 'integer', [
            'after' => 'lft',
            'null' => false,
            'limit' => 5
        ]);
        $table->addColumn('product_id', 'integer', [
            'after' => 'lft',
            'null' => false,
            'limit' => 11
        ]);
        $table->addColumn('customer_id', 'integer', [
            'after' => 'lft',
            'null' => false,
            'limit' => 11
        ]);
        $table->addColumn('comment', 'text', [
            'null' => true,
        ]);
        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);
        $table->addIndex(['product_id']);
        $table->addIndex(['customer_id']);
        $table->create();
    }
}
