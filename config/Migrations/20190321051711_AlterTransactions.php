<?php
use Migrations\AbstractMigration;

class AlterTransactions extends AbstractMigration
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

        $table->addColumn('transaction_id', 'string', [
            'default' => null,
            'limit' => 40,
            'null' => true,
            'after' => 'order_id'
        ]);

        $table->addIndex(['transaction_id']);
        $table->addIndex(['order_id']);


        $table->update();
    }
}
