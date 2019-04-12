<?php
use Migrations\AbstractMigration;

class AltercreateIpLocations extends AbstractMigration
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
        $table = $this->table('ip_locations');

        $table->changeColumn('organisation', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 150,
        ]);

        $table->update();
    }
}
