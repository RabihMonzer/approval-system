<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertRolesData extends Migration
{
    const ROLE_MODERATOR = 'Moderator';
    const ROLE_MANAGER = 'Manager';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Db::table('roles')->insert([
            [
                'name' => self::ROLE_MODERATOR,
                'created_at' => new DateTime(),
            ],
            [
                'name' => self::ROLE_MANAGER,
                'created_at' => new DateTime(),
            ]]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Db::table('roles')->delete([
                [
                    'name' => self::ROLE_MODERATOR,
                ],
                [
                    'name' => self::ROLE_MANAGER,
                ]]
        );
    }
}
