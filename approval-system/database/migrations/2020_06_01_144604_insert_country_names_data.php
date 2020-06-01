<?php

use Illuminate\Database\Migrations\Migration;
use Monarobase\CountryList\CountryListFacade;

class InsertCountryNamesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (CountryListFacade::getList() as $countryShortCode => $countryName) {
            \Illuminate\Support\Facades\DB::table('countries')->insert(
                [
                    'name' => $countryName,
                    'short_code' => $countryShortCode,
                    'created_at' => new DateTime(),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::table('countries')->truncate();
    }
}
