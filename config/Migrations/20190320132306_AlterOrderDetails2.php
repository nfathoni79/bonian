<?php
use Migrations\AbstractMigration;

class AlterOrderDetails2 extends AbstractMigration
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
        $table = $this->table('order_details');


        $table->addColumn('province_id', 'integer', [
            'default' => null,
            'null' => true,
            'after' => 'awb',
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

        $table->addColumn('shipping_code', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 10,
            'after' => 'product_price',
        ]);

        $table->addColumn('shipping_service', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 10,
            'after' => 'shipping_code',
        ]);

        $table->addColumn('shipping_weight', 'integer', [
            'default' => 0,
            'null' => true,
            'after' => 'shipping_service',
        ]);

        if ($table->hasForeignKey(['origin_subdistrict_id'], 'order_details_ibfk_4')) {
            $table->dropForeignKey('origin_subdistrict_id', 'order_details_ibfk_4')
                ->save();
        }

        if ($table->hasForeignKey(['destination_subdistrict_id'], 'order_details_ibfk_5')) {
            $table->dropForeignKey('destination_subdistrict_id', 'order_details_ibfk_5')
                ->save();
        }

        if ($table->hasForeignKey(['origin_city_id'], 'order_details_ibfk_6')) {
            $table->dropForeignKey('origin_city_id', 'order_details_ibfk_6')
                ->save();
        }

        if ($table->hasForeignKey(['destination_city_id'], 'order_details_ibfk_7')) {
            $table->dropForeignKey('destination_city_id', 'order_details_ibfk_7')
                ->save();
        }

        if($table->hasColumn('courrier_code')) {
            $table->removeColumn('courrier_code');
        }

        if($table->hasColumn('origin_subdistrict_id')) {
            $table->removeColumn('origin_subdistrict_id');
        }

        if($table->hasColumn('destination_subdistrict_id')) {
            $table->removeColumn('destination_subdistrict_id');
        }

        if($table->hasColumn('origin_city_id')) {
            $table->removeColumn('origin_city_id');
        }

        if($table->hasColumn('destination_city_id')) {
            $table->removeColumn('destination_city_id');
        }

        $table->addIndex(['province_id', 'city_id', 'subdistrict_id', 'shipping_code', 'shipping_service']);

        $table->update();
    }
}
