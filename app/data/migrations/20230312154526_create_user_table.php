<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('user', ['id' => true]);
        $table->addColumn('full_name', 'string', ['limit' => 255])
            ->addColumn('birth_date', 'date')
            ->addColumn('birth_place_id', 'integer', ['signed' => false])
            ->addForeignKey('birth_place_id', 'birth_place', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();
    }

    public function down()
    {
        $this->table('user')->drop()->save();
    }
}
