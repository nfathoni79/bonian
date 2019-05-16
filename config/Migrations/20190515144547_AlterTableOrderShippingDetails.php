<?php
use Migrations\AbstractMigration;

class AlterTableOrderShippingDetails extends AbstractMigration
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
        $table = $this->table('order_shipping_details');

        $table->addColumn('status', 'integer', [
            'limit' => 11,
            'after' => 'order_detail_id',
            'null' => false,
            'default' => 1,
            'comment' => '1 : menunggu pembayaran, 2 : di proses, 3 : dikirim, 4 : selesai'
        ]);
        $table->update();
    }
}
