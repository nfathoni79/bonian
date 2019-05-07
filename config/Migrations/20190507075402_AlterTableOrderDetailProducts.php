<?php
use Migrations\AbstractMigration;

class AlterTableOrderDetailProducts extends AbstractMigration
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
        $table = $this->table('order_detail_products');

        $table->addColumn('product_category_id', 'integer', [
            'default' => null,
            'null' => true,
            'after' => 'product_id',
            'limit' => 11
        ]);

        $table->addColumn('bonus_point', 'integer', [
            'default' => 0,
            'null' => true,
            'after' => 'product_category_id',
            'limit' => 8
        ]);

        $table->update();
    }
}
