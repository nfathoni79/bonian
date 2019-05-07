<?php
use Migrations\AbstractMigration;

class AlterTableDigitalDetails1 extends AbstractMigration
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
        $table = $this->table('digital_details');

        $table->addColumn('type', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 50
        ]);

        $table->addIndex(['code']);
        $table->addIndex(['type']);

        $table->update();
    }
}
