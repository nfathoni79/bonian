<?php
use Migrations\AbstractMigration;

class AlterTableCartDetails extends AbstractMigration
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
        $table = $this->table('customer_cart_details');

        $table->addColumn('product_category_id', 'integer', [
            'null' => false,
            'after' => 'product_id',
            'limit' => 11
        ]);
        $table->update();
    }
}
