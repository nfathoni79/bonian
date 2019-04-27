<?php
use Migrations\AbstractMigration;

class AlterTableProducts4 extends AbstractMigration
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

        $table->changeColumn('highlight_text', 'text', [
            'default' => null,
            'null' => true,
        ]);

        if ($table->hasIndexByName('fulltext_index')) {
            $table->removeIndexByName('fulltext_index');
            $table->save();
        }

        $table->addIndex(['name', 'highlight_text'], ['type' => 'fulltext', 'name' => 'fulltext_index']);
        $table->addIndex('sku');

        $table->update();
    }
}
