<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDepartmentTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('department', ['id' => true]);
        $table->addColumn('name_ru', 'string', ['limit' => 255])
            ->addColumn('name_en', 'string', ['limit' => 255])
            ->create();
    }

    public function down()
    {
        $this->table('department')->drop()->save();
    }
}
