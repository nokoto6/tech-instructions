<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Instructions;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Администрация',
            'email' => 'admin@admin.com',
            'password' => '15akadmin',
            'is_admin' => true
        ]);

        /*
        for ($i=0; $i < 4; $i++) { error_log('------------------------------------------------------------------------------------------'); }
        error_log('Для аутентификации в качестве админа используйте E-Mail: admin@admin.com , Password: 15akadmin');
        for ($i=0; $i < 4; $i++) { error_log('------------------------------------------------------------------------------------------'); }

        for ($i = 0; $i <= 100; $i++) {
            Instructions::create([
                'item_name' => 'TestInstr#' . $i,
                'uploader_id' => '1',
                'description' => 'Test description for item#' . $i,
                'file' => '/uploads/instructions/Alt.pdf',
                'accepted' => random_int(0, 1),
                'category_id' => random_int(1, 3),
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

        for ($i = 0; $i <= 10; $i++) {
            Category::create([
                'item_name' => 'CategoryName' . $i,
                'google_symbol_name' => 'kitchen'
            ]);
        }
        */

        $filePath = resource_path('json\instruction_seed.json');
        $jsonContent = File::get($filePath);
        $instructions = json_decode($jsonContent, true);

        error_log('Ожидайте, идет засеивание с проверкой файлов, примерное время 5 минут');

        foreach ($instructions as $key => $item) {
            if(checkFileExists($item['file'])) {
                Instructions::create([
                    'item_name' => $item['item_name'],
                    'uploader_id' => '1',
                    'description' => '',
                    'file' => $item['file'],
                    'accepted' => '1',
                    'category_id' => $item['category_id']+1,
                ]);
            }
        }

        $filePath = resource_path('json\category_seed.json');
        $jsonContent = File::get($filePath);
        $categories = json_decode($jsonContent, true);

        foreach ($categories as $key => $item) {
            Category::create([
                'item_name' => $item['item_name'],
                'google_symbol_name' => $item['google_symbol_name']
            ]);
        }
    }
}
