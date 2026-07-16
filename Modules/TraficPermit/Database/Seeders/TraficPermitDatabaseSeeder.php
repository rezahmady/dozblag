<?php

namespace Modules\TraficPermit\Database\Seeders;

use Illuminate\Database\Seeder;

class TraficPermitDatabaseSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(DefaultDatabaseSeeder::class);
        $this->call(RepositoryTableSeeder::class);
        $this->call(CountryPermissionTableSeeder::class);
        $this->call(PermitOrderTableSeeder::class);
        $this->call(TraficPermitTypeTableSeeder::class);
        $this->call(TraficPermitTemplateTableSeeder::class);
        $this->call(CorrectExportTableSeeder::class);
        $this->call(TraficPermitExportTableSeeder::class);
        $this->call(TotalReportTableSeeder::class);
        $this->call(TraficPermitTransactionTableSeeder::class);
        $this->call(TraficPermitTransactionManageTableSeeder::class);
        $this->call(TraficPermitReportTableSeeder::class);
        $this->call(TraficPermitGeneralSettingTableSeeder::class);
    }
}
