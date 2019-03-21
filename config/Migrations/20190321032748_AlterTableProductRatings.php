<?php
use Migrations\AbstractMigration;

class AlterTableProductRatings extends AbstractMigration
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

        $table->addColumn('order_detail_product_id', 'integer', [
            'default' => null,
            'null' => true,
            'after' => 'id',
        ]);

        $table->addColumn('status', 'integer', [
            'default' => '0',
            'null' => true,
        ]);

        $table->addIndex(['order_detail_product_id']);
        $table->update();
    }
}
