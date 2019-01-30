<?php
use Migrations\AbstractMigration;

class CreateTableOrders extends AbstractMigration
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
        $table->addColumn('orderid', 'string', [
            'default' => null,
            'limit' => 15,
            'null' => true
        ]);
        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'limit' => 9,
            'null' => true
        ]);
        $table->addColumn('address', 'text', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('customer_shipping_type', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => true
        ]);
        $table->addColumn('shipping_price', 'decimal', [
            'default' => null,
            'precision'=>11,
            'scale'=>2,
            'null' => true
        ]);
        $table->addColumn('weight', 'integer', [
            'default' => null,
            'limit' => 7,
            'null' => true
        ])
;        $table->addColumn('uniq_code', 'integer', [
            'default' => null,
            'limit' => 5,
            'null' => true
        ]);
        $table->addColumn('total', 'decimal', [
            'default' => null,
            'precision'=>11,
            'scale'=>2,
            'null' => true
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true

        ]);
        $table->addForeignKey('customer_id', 'customers', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}









