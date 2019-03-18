<?php
use Migrations\AbstractMigration;

class AlterOrders extends AbstractMigration
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
        $table = $this->table('orders');

        $table->addColumn('use_point', 'integer', [
            'null' => true,
            'default' => 0,
            'after' => 'product_promotion_id'
        ]);

        $table->addColumn('gross_total', 'float', [
            'null' => true,
            'default' => 0,
            'after' => 'use_point',
            'comment' => 'Total keselurahan kotor, untuk net nya gunakan field total'
        ]);

        $table->update();
    }
}
