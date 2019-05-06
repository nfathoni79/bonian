<?php
use Migrations\AbstractMigration;

class CreateTableCustomerDigitalInquiry extends AbstractMigration
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
        $table = $this->table('customer_digital_inquiry');

        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11,
        ]);

        $table->addColumn('customer_number', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 20,
        ]);

        $table->addColumn('code', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 15,
        ]);

        $table->addColumn('status', 'boolean', [
            'default' => 0,
            'null' => true
        ]);

        $table->addColumn('raw_request', 'text', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('raw_response', 'text', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
        ]);

        $table->addIndex(['customer_id']);
        $table->addIndex(['customer_number']);
        $table->addIndex(['code']);


        $table->create();
    }
}
