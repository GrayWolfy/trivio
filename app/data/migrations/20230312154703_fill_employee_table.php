<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FillEmployeeTable extends AbstractMigration
{
    public function up()
    {
        $this->execute("
            INSERT INTO employee (full_name) VALUES
            ('Иванов Иван Иванович'),
            ('Петров Петр Петрович'),
            ('Сидоров Сидор Сидорович')
        ");
    }

    public function down()
    {
        $this->execute("
            TRUNCATE employee
        ");
    }
}
