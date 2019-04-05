<?php
use Migrations\AbstractMigration;

class AlterBanners extends AbstractMigration
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
        $table = $this->table('banners');

        $table->addColumn('position', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true,
            'after' => 'status'
        ]);


        $table->update();
    }
}
