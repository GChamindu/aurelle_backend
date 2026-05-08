<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        // Update only the intended admin user
        DB::table('users')
            ->where('email', 'copper@gmail.com')
            ->update([
                'password' => Hash::make('Copper@880770'),
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Cannot safely restore old password hash unless you stored it before.
        // Leave empty or log a note.
    }
};
