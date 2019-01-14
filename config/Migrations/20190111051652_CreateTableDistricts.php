<?php
use Migrations\AbstractMigration;

class CreateTableDistricts extends AbstractMigration
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
        $table = $this->table('districts');
        $table->addColumn('regency_id', 'integer', [
            'default' => null,
            'limit' => 11,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
        ]);
        $table->addIndex('regency_id');
        $table->addForeignKey('regency_id', 'regencies', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
