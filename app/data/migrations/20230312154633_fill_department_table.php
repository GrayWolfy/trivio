<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FillDepartmentTable extends AbstractMigration
{
    public function up()
    {
        $this->execute("
            INSERT INTO department (name_ru, name_en) VALUES
            ('Отдел продаж', 'Sales Department'),
            ('Отдел разработки', 'Development Department'),
            ('Отдел маркетинга', 'Marketing Department')
        ");
    }

    public function down()
    {
        $this->execute("
            TRUNCATE department
        ");
    }
}
