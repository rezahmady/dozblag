<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trafic_permit_typeables', function (Blueprint $table) {
            $table->index(
                ['trafic_permit_typeable_id', 'trafic_permit_typeable_type', 'trafic_permit_type_id'],
                'typeables_morph_type_idx'
            );
        });

        Schema::table('trafic_permits', function (Blueprint $table) {
            $table->index(['status', 'repository_id'], 'permits_status_repo_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trafic_permit_typeables', function (Blueprint $table) {
            $table->dropIndex('typeables_morph_type_idx');
        });

        Schema::table('trafic_permits', function (Blueprint $table) {
            $table->dropIndex('permits_status_repo_idx');
        });
    }
};
