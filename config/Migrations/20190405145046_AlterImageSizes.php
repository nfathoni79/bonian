<?php
use Migrations\AbstractMigration;

class AlterImageSizes extends AbstractMigration
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
        $table = $this->table('image_sizes');

        if ($table->hasIndexByName('model')) {
            $table->removeIndex(['model', 'foreign_key']);
            $table->addIndex(['model']);
            $table->addIndex(['foreign_key']);
            $table->addIndex(['dimension']);
        }

        $table->update();
    }
}
