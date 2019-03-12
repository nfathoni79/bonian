<?php
use Migrations\AbstractMigration;

class AlterTablePriceSettings extends AbstractMigration
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
        $table = $this->table('price_settings');

        $table->changeColumn('schedule', 'datetime', [
            'null' => false
        ]);
        $table->update();
    }
}
