<?php
use Migrations\AbstractMigration;

class AlterTableOrdersDigitals extends AbstractMigration
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
        $table = $this->table('order_digitals');

        $table->addColumn('order_id', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11,
            'after' => 'id'
        ]);

        $table->addIndex(['order_id']);

        if ($table->hasColumn('order_detail')) {
            $table->removeColumn('order_detail');
        }

        $table->update();
    }
}
