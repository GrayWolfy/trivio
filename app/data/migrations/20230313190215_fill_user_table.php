<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FillUserTable extends AbstractMigration
{
    public function up()
    {
        $this->execute("
            INSERT INTO user (full_name, birth_date, birth_place_id) VALUES ('John Doe', '1990-01-01', 1);
            INSERT INTO user (full_name, birth_date, birth_place_id) VALUES ('Jane Smith', '1985-05-05', 2);
            INSERT INTO user (full_name, birth_date, birth_place_id) VALUES ('Bob Johnson', '1980-12-25', 3);
        ");
    }

    public function down()
    {
        $this->execute('DELETE FROM user');
    }
}
