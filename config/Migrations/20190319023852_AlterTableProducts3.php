<?php
use Migrations\AbstractMigration;

class AlterTableProducts3 extends AbstractMigration
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
        $table = $this->table('products');

        $table->addColumn('type', 'string', [
            'limit' => 15,
            'null' => true,
            'after' => 'rating'
        ]);
        $table->update();
    }
}
