<?php
use Migrations\AbstractMigration;

class CreateCustomerCards extends AbstractMigration
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

        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('is_primary', 'boolean', [
            'default' => 0,
            'null' => true
        ]);

        $table->addColumn('masked_card', 'string', [
            'default' => null,
            'limit' => 15,
            'null' => true
        ]);

        $table->addColumn('token', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true
        ]);

        $table->addColumn('expired_at', 'datetime', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null
        ]);

        $table->addIndex(['customer_id']);
        $table->addForeignKey('customer_id', 'customers', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);

        $table->create();
    }
}
