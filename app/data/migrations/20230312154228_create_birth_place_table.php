<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBirthPlaceTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('birth_place', ['id' => true]);
        $table->addColumn('name_ru', 'string', ['limit' => 255])
            ->addColumn('name_en', 'string', ['limit' => 255])
            ->create();
    }

    public function down()
    {
        $this->table('birth_place')->drop()->save();
    }
}
