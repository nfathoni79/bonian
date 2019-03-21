<?php
use Migrations\AbstractMigration;

class AlterOrderDetailProducts2 extends AbstractMigration
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

        $table->addColumn('comment', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'after' => 'total'
        ]);

        $table->update();
    }
}
