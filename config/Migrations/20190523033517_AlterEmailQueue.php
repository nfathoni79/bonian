<?php
use Migrations\AbstractMigration;

class AlterEmailQueue extends AbstractMigration
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
        $table = $this->table('email_queue');

        $table->changeColumn('subject', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true
        ]);

        $table->changeColumn('layout', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true
        ]);

        $table->update();
    }
}
