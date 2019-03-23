<?php
use Migrations\AbstractMigration;

class AlterOrders4 extends AbstractMigration
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

        $table->changeColumn('product_promotion_id', 'integer', [
            'default' => null,
            'null' => true,
        ]);

        $table->update();
    }
}
