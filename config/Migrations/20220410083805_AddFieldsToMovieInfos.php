<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AddFieldsToMovieInfos extends AbstractMigration
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
        $table = $this->table('movies_info');
        $table->addColumn('resolution', 'string', [
            'default' => 'SD',
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('subtitle', 'string', [
            'default' => 'VietSub',
            'limit' => 30,
            'null' => false,
        ]);
        $table->addColumn('tags', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('session', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('year', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('topview', 'string', [
            'default' => 'tuan',
            'limit' => 30,
            'null' => false,
        ]);
        $table->addColumn('sesson', 'string', [
            'default' => 0,
            'limit' => 255,
            'null' => false,
        ]);
        $table->update();
    }
}
