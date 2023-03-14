<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEmployeeTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('employee', ['id' => true]);
        $table->addColumn('full_name', 'string', ['limit' => 255])
            ->create();
    }

    public function down()
    {
        $this->table('employee')->drop()->save();
    }
}
