<?php
use Migrations\AbstractMigration;

class CreateTableFaqs extends AbstractMigration
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
        $table = $this->table('faqs');
        $table->addColumn('faq_category_id', 'string', [
            'null' => false,
            'limit' => 150,
        ]);
        $table->addColumn('judul', 'string', [
            'null' => false,
            'limit' => 150,
        ]);
        $table->addColumn('content', 'text', [
            'null' => false,
        ]);
        $table->addColumn('status', 'integer', [
            'null' => false,
            'limit' => 1,
        ]);
        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'null' => false,
        ]);
        $table->addIndex('faq_category_id');
//        $table->addForeignKey('faq_category_id', 'faq_categories', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);
        $table->create();
    }
}
