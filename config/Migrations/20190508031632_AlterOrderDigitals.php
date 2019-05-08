<?php
use Migrations\AbstractMigration;

class AlterOrderDigitals extends AbstractMigration
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

        $table->addColumn('bonus_point', 'integer', [
            'default' => 0,
            'null' => true,
            'limit' => 8,
            'after' => 'raw_response'
        ]);

        $table->addColumn('status', 'integer', [
            'default' => 0,
            'null' => true,
            'limit' => 2,
            'comment' => '0: pending, 1: success, 2: failed',
            'after' => 'bonus_point'
        ]);

        $table->addIndex(['status']);

        $table->update();
    }
}
