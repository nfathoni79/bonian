<?php
use Migrations\AbstractMigration;

class CreateTableProductCoupons extends AbstractMigration
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
        $table = $this->table('product_coupons');

        $table->addColumn('product_id', 'integer', [
            'null' => true,
            'limit' => 11,
            'default' => null
        ]);
        $table->addColumn('sku', 'string', [
            'null' => true,
            'limit' => 25,
            'default' => null
        ]);
        $table->addColumn('price', 'float', [
            'default' => null
        ]);
        $table->addColumn('expired', 'date', [
            'default' => null
        ]);
        $table->addColumn('status', 'integer', [
            'null' => false,
            'limit' => 1,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null
        ]);

        $table->addIndex(['product_id']);
        $table->create();
    }
}
