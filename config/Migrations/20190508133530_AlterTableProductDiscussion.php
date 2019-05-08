<?php
use Migrations\AbstractMigration;

class AlterTableProductDiscussion extends AbstractMigration
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

        $table->addColumn('read', 'boolean', [
            'default' => false,
            'after' => 'comment',
        ]);
        $table->update();
    }
}
