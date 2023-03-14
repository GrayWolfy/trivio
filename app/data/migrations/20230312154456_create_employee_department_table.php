<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEmployeeDepartmentTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('employee_department', ['id' => true]);
        $table->addColumn('employee_id', 'integer', ['signed' => false])
            ->addColumn('department_id', 'integer', ['signed' => false])
            ->addForeignKey('employee_id', 'employee', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey('department_id', 'department', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();
    }

    public function down()
    {
        $this->table('employee_department')->drop()->save();
    }
}
