<?php
use Migrations\AbstractMigration;

class CreateTableVillages extends AbstractMigration
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
        $table = $this->table('villages');
        $table->addColumn('district_id', 'integer', [
            'default' => null,
            'limit' => 11,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
        ]);
        $table->addIndex('district_id');
        $table->addForeignKey('district_id', 'districts', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
