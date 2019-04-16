<?php
use Migrations\AbstractMigration;

class AlterCustomerCards extends AbstractMigration
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
        $table = $this->table('customer_cards');

        $table->addColumn('type', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 20,
            'after' => 'masked_card'
        ]);

        $table->update();
    }
}
