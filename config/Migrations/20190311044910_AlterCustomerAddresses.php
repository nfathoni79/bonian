<?php
use Migrations\AbstractMigration;

class AlterCustomerAddresses extends AbstractMigration
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

        $table->addColumn('is_primary', 'boolean', [
            'default' => 0,
            'null' => true,
            'after' => 'subdistrict_id'
        ]);

        $table->update();
    }
}
