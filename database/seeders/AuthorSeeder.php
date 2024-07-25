<?php

namespace Database\Seeders;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Author::create([
                'author' => 'Autor ' . $i,
                'birthday' => Carbon::now(),
            ]);
        }
    }
}
