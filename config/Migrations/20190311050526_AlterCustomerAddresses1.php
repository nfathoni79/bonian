<?php
use Migrations\AbstractMigration;

class AlterCustomerAddresses1 extends AbstractMigration
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
        $table = $this->table('customer_addreses');

        $table->addColumn('title', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 50,
            'after' => 'is_primary'
        ]);

        $table->addColumn('recipient_name', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 50,
            'after' => 'title'
        ]);

        $table->addColumn('recipient_phone', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 50,
            'after' => 'recipient_name'
        ]);

        $table->addColumn('latitude', 'decimal', [
            'default' => 0,
            'precision' => 9,
            'scale' => 6,
            'null' => true,
            'after' => 'recipient_phone'
        ]);

        $table->addColumn('longitude', 'decimal', [
            'default' => 0,
            'precision' => 9,
            'scale' => 6,
            'null' => true,
            'after' => 'latitude'
        ]);


        $table->update();
    }
}
