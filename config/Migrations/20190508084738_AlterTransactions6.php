<?php
use Migrations\AbstractMigration;

class AlterTransactions6 extends AbstractMigration
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

        $table->addColumn('status_code', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 3,
            'after' => 'transaction_status'
        ]);

        $table->addColumn('eci', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 3,
            'after' => 'card_type'
        ]);

        $table->addColumn('is_called', 'boolean', [
            'default' => 0,
            'null' => true,
            'after' => 'eci'
        ]);

        $table->addIndex(['status_code']);

        $table->update();
    }
}
