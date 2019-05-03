<?php
use Migrations\AbstractMigration;

class AlterTransactions1 extends AbstractMigration
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

        $table->addColumn('raw_response', 'text', [
            'default' => null,
            'null' => true,
            'after' => 'approval_code'
        ]);

        $table->update();
    }
}
