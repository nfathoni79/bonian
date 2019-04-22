<?php
use Migrations\AbstractMigration;

class AlterTableDigitalDetails extends AbstractMigration
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

        $table->addColumn('point', 'integer', [
            'default' => 0,
            'null' => true,
            'limit' => 8,
            'after' => 'price'
        ]);

        $table->update();
    }
}
