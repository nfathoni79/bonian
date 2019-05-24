<?php
use Migrations\AbstractMigration;

class AlterTableProductDiscussions extends AbstractMigration
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
        $table = $this->table('product_discussions');
        $table->changeColumn('customer_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('to_customer', 'integer', [
            'limit' => 11,
            'null' => true,
            'default' => null,
            'after' => 'customer_id',
        ]);
        $table->addColumn('user_id', 'integer', [
            'limit' => 11,
            'null' => true,
            'default' => null,
            'after' => 'to_customer',
        ]);
        $table->addColumn('is_admin', 'boolean', [
            'null' => true,
            'default' => false,
            'after' => 'to_customer',
        ]);
        $table->update();
    }
}
