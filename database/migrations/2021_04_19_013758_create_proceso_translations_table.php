<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesoTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('proceso_id')->constrained('procesos')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description');

            $table->unique(['proceso_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proceso_translations');
    }
}
