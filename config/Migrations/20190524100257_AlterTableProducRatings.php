<?php
use Migrations\AbstractMigration;

class AlterTableProducRatings extends AbstractMigration
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

        if ($table->hasColumn('order_detail_product_id')) {
            $table->removeColumn('order_detail_product_id');
        }

        $table->addColumn('order_id', 'integer', [
            'limit' => 11,
            'null' => true,
            'default' => null,
            'after' => 'id',
        ]);
        $table->addForeignKey('order_id', 'orders', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->update();
    }
}
