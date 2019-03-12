<?php
use Migrations\AbstractMigration;

class CreateTransactions extends AbstractMigration
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
        $table = $this->table('transactions');

        $table->addColumn('order_id', 'integer', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('transaction_time', 'datetime', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('transaction_code', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true
        ]);

        $table->addColumn('transaction_status', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => true
        ]);

        $table->addColumn('fraud_status', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => true
        ]);

        $table->addColumn('gross_amount', 'float', [
            'default' => 0,
            'null' => true
        ]);

        $table->addColumn('currency', 'string', [
            'default' => null,
            'limit' => 3,
            'null' => true
        ]);

        $table->addColumn('payment_type', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => true
        ]);

        $table->addColumn('bank', 'string', [
            'default' => null,
            'limit' => 10,
            'null' => true
        ]);

        $table->addColumn('va_number', 'string', [
            'default' => null,
            'limit' => 25,
            'null' => true
        ]);

        $table->addColumn('masked_card', 'string', [
            'default' => null,
            'limit' => 25,
            'null' => true
        ]);

        $table->addColumn('card_type', 'string', [
            'default' => null,
            'limit' => 15,
            'null' => true
        ]);

        $table->addColumn('approval_code', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => true
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null
        ]);

        $table->addColumn('modified', 'datetime', [
            'default' => null
        ]);

        $table->create();
    }
}
