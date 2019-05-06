<?php
use Migrations\AbstractMigration;

class CreateTableOrderDigitals extends AbstractMigration
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
        $table = $this->table('order_digitals');

        $table->addColumn('order_detail', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11
        ]);

        $table->addColumn('digital_detail_id', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11
        ]);

        $table->addColumn('customer_number', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 20
        ]);


        $table->addColumn('price', 'float', [
            'default' => 0,
            'null' => true,
        ]);


        $table->addColumn('raw_response', 'text', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
        ]);

        $table->addIndex(['order_detail']);
        $table->addIndex(['digital_detail_id']);

        $table->create();
    }
}
