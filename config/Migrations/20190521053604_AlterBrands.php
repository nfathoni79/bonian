<?php
use Migrations\AbstractMigration;

class AlterBrands extends AbstractMigration
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
        $table = $this->table('brands');

        $table->addColumn('logo', 'string', [
            'default' => null,
            'limit' => 255,
            'after' => 'name',
            'null' => true
        ]);

        $table->addColumn('dir', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'after' => 'logo'
        ]);

        $table->addColumn('size', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
            'after' => 'dir'
        ]);

        $table->addColumn('type', 'string', [
            'default' => null,
            'limit' => 150,
            'null' => true,
            'after' => 'size'
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->update();
    }
}
