<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateMovies extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('movies');
        $table->addColumn('m_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('m_slug', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('m_desc', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('modified', 'date', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
