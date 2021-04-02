<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('title');
            $table->text('content');

            $table->unique(['task_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_translations');
    }
}
