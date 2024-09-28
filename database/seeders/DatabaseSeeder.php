<?php

namespace Database\Seeders;

use App\Models\Instructions;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'is_admin' => true
        ]);

        for ($i=0; $i < 4; $i++) { error_log('------------------------------------------------------------------------------------------'); }
        error_log('Для аутентификации в качестве админа используйте E-Mail: admin@admin.com , Password: admin');
        for ($i=0; $i < 4; $i++) { error_log('------------------------------------------------------------------------------------------'); }

        for ($i = 0; $i <= 100; $i++) {
            Instructions::create([
                'item_name' => 'TestInstr#' . $i,
                'uploader_id' => '1',
                'description' => 'Test description for item#' . $i,
                'file' => '/uploads/instructions/Alt.pdf',
                'accepted' => random_int(0, 1)
            ]);
        }

        for ($i = 0; $i <= 30; $i++) {
            User::create([
                'name' => 'TestUser#' . $i,
                'email' => 'TestEmail' . $i . '@test.com',
                'password' => 'testpass',
                'is_admin' => false
            ]);
        }
    }
}
