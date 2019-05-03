<?php
use Migrations\AbstractMigration;

class AlterTableProducts5 extends AbstractMigration
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
        $table->addColumn('price_sale_previous', 'float', [
            'default' => 0,
            'null' => true
        ]);
        $table->addColumn('is_flash_sale', 'boolean', [
            'default' => false
        ]);
        $table->update();
    }
}
