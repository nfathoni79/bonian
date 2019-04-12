<?php
use Migrations\AbstractMigration;

class AlterCustomerAddresses2 extends AbstractMigration
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

        $table->addColumn('postal_code', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 5,
            'after' => 'longitude'
        ]);

        $table->update();
    }
}
