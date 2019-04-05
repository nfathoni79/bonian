<?php
use Migrations\AbstractMigration;

class CreateTableImageSizes extends AbstractMigration
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
        $table = $this->table('image_sizes');

        $table->addColumn('model', 'string', [
            'default' => null,
            'limit' => 150
        ]);

        $table->addColumn('foreign_key', 'integer', [
            'default' => null,
            'null' => true
        ]);

        $table->addColumn('dimension', 'string', [
            'default' => null,
            'limit' => 9
        ]);
        $table->addColumn('path', 'string', [
            'default' => null,
            'limit' => 255
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
        ]);

        $table->addIndex(['model', 'foreign_key'], ['unique' => true]);


        $table->create();
    }
}
