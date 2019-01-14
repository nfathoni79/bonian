<?php
use Migrations\AbstractMigration;

class CreateTableProductDeals extends AbstractMigration
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
        $table = $this->table('product_deals');
        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('date_start', 'datetime', [
            'default' => null
        ]);
        $table->addColumn('date_end', 'datetime', [
            'default' => null
        ]);
        $table->addIndex('product_id');
        $table->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
