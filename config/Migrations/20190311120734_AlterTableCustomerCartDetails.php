<?php
use Migrations\AbstractMigration;

class AlterTableCustomerCartDetails extends AbstractMigration
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
        $table->addColumn('point', 'float', [
            'default' => 0,
            'null' => false,
            'after' => 'price'
        ]);
        $table->addColumn('totalpoint', 'float', [
            'default' => 0,
            'null' => false,
            'after' => 'total'
        ]);
        $table->addColumn('comment', 'text', [
            'null' => true,
            'after' => 'totalpoint'
        ]);
        $table->update();
    }
}
