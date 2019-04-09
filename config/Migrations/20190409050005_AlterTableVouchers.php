<?php
use Migrations\AbstractMigration;

class AlterTableVouchers extends AbstractMigration
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
        $table = $this->table('vouchers');

        $table->addColumn('name', 'string', [
            'limit' => '100',
            'null' => false,
            'after' => 'id'
        ]);
        $table->addColumn('slug', 'string', [
            'limit' => '100',
            'null' => false,
            'after' => 'name'
        ]);
        $table->changeColumn('type', 'integer', [
            'default' => 0,
            'null' => true,
            'limit' => 1,
            'comment' => '1 : point, 2 : chain to category'
        ]);
        $table->addColumn('point', 'float', [
            'default' => 0,
            'comment' => 'nilai redeem point',
            'after' => 'type'
        ]);
        $table->addColumn('percent', 'float', [
            'default' => null,
            'comment' => 'nilai diskon dalam persen',
            'after' => 'point'
        ]);
        $table->changeColumn('value', 'float', [
            'default' => null,
            'comment' => 'nilai maksimal voucher'
        ]);
        $table->addColumn('tos', 'text', [
            'default' => null,
            'null' => true,
            'after' => 'value'
        ]);
        $table->update();
    }
}
