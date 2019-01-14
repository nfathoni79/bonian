<?php
use Migrations\AbstractMigration;

class CreateTableAttributeGroups extends AbstractMigration
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
        $table = $this->table('attribute_groups');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 50
        ]);
        $table->addColumn('description', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true
        ]);
        $table->addColumn('sort_order', 'integer', [
            'default' => null,
            'limit' => 3,
            'null' => true
        ]);
        $table->create();
    }
}
