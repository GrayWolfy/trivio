<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FillBirthplaceTable extends AbstractMigration
{
    public function up()
    {
        $this->execute("
            INSERT INTO birth_place (name_ru, name_en) VALUES
            ('Москва', 'Moscow'),
            ('Санкт-Петербург', 'Saint Petersburg'),
            ('Казань', 'Kazan')
        ");
    }

    public function down()
    {
        $this->execute("
            TRUNCATE birth_place
        ");
    }
}
