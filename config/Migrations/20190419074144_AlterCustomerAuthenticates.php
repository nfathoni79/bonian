<?php
use Migrations\AbstractMigration;

class AlterCustomerAuthenticates extends AbstractMigration
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
        $table = $this->table('customer_authenticates');

        $table->addColumn('browser_id', 'integer', [
            'default' => null,
            'null' => true,
            'limit' => 11,
            'after' => 'token'
        ]);

        if ($table->hasColumn('bid')) {
            $table->removeColumn('bid');
        }

        if ($table->hasColumn('browser')) {
            $table->removeColumn('browser');
        }

        $table->addIndex(['browser_id']);


        $table->update();
    }
}
