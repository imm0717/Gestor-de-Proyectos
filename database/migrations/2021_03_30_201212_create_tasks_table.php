<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id')->nullable();
            $table->foreignUuid('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('name', 256)->nullable(false);
            $table->text('description');
            $table->date('start_date')->nullable(false);
            $table->date('end_date')->nullable(false);
            $table->date('real_end_date')->nullable();
            $table->foreignId('responsible_id')->nullable()->constrained('users','id')->nullOnDelete();
            $table->foreignId('created_by_id')->constrained('users','id')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('tasks')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
