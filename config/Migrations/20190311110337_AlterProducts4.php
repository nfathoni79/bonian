<?php
use Migrations\AbstractMigration;

class AlterProducts4 extends AbstractMigration
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

        $table->addColumn('rating_count', 'integer', [
            'default' => 0,
            'null' => true,
            'after' => 'rating'
        ]);


        $table->update();
    }
}
