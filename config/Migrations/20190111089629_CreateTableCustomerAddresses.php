<?php
use Migrations\AbstractMigration;

class CreateTableCustomerAddresses extends AbstractMigration
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
        $table = $this->table('customer_addresses');
        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('province_id', 'integer', [
            'default' => null,
            'limit' => 4,
            'null' => true
        ]);
        $table->addColumn('regency_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true
        ]);
        $table->addColumn('district_id', 'integer', [
            'default' => null,
            'limit' => 11,
        ]);
        $table->addColumn('village_id', 'integer', [
            'default' => null,
            'limit' => 11,
        ]);
        $table->addColumn('address', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true
        ]);
        $table->addIndex('customer_id');
        $table->addForeignKey('customer_id', 'customers', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('province_id');
        $table->addForeignKey('province_id', 'provinces', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('regency_id');
        $table->addForeignKey('regency_id', 'regencies', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('district_id');
        $table->addForeignKey('district_id', 'districts', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->addIndex('village_id');
        $table->addForeignKey('village_id', 'villages', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
