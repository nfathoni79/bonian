<?php
use Migrations\AbstractMigration;

class AlterOrders1 extends AbstractMigration
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

        $table->addColumn('province_id', 'integer', [
            'default' => null,
            'null' => true,
            'after' => 'customer_id',
        ]);

        $table->addColumn('city_id', 'integer', [
            'default' => null,
            'null' => true,
            'after' => 'province_id',
        ]);

        $table->addColumn('subdistrict_id', 'integer', [
            'default' => null,
            'null' => true,
            'after' => 'city_id',
        ]);

        $table->addIndex(['province_id', 'city_id', 'subdistrict_id']);

        $table->update();
    }
}
