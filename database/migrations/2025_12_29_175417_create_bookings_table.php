<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bookable_type'); // App\Models\Room atau App\Models\Facility
            $table->unsignedBigInteger('bookable_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('purpose');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            
            $table->index(['bookable_type', 'bookable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};