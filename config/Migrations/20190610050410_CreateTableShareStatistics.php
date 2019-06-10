<?php
use Migrations\AbstractMigration;

class CreateTableShareStatistics extends AbstractMigration
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
        $table = $this->table('share_statistics');

        $table->addColumn('product_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);

        $table->addColumn('media_type', 'string', [
            'default' => null,
            'limit' => 10,
            'null' => true,
        ]);

        $table->addColumn('customer_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);

        $table->addColumn('clicked', 'boolean', [
            'default' => 0,
            'null' => true,
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addIndex(['product_id']);
        $table->addIndex(['media_type']);
        $table->addIndex(['customer_id']);


        $table->create();
    }
}
