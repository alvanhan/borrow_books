<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                "isbn" => "hj846",
                "image" => "http://t1.gstatic.com/images?q=tbn:ANd9GcQvJJDi2mzwg9v_PlmKYL31gXIz0kvAObJak7DVFPcD_mJTIyec",
                "title" => "Norwegian Wood",
                "author" => "Haruki Murakami",
                "year" => 1987,
                "stock" => 5,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "isbn" => "op012",
                "image" => "http://t0.gstatic.com/images?q=tbn:ANd9GcRHFU_j93PPsbQGqoaZJnHH6-Emk_sIxG823SkoRTL0nvdEP41f",
                "title" => "Kafka on the Shore",
                "author" => "Haruki Murakami",
                "year" => 2002,
                "stock" => 10,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "isbn" => "cv456",
                "image" => "http://t3.gstatic.com/images?q=tbn:ANd9GcQBMNA8A19vQpNY4bkgadsLhiRUFqBKwKAA6ANrw8VEtOiPrYQJ",
                "title" => "After Dark",
                "author" => "Haruki Murakami",
                "year" => 2004,
                "stock" => 4,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "isbn" => "al207",
                "image" => "http://t0.gstatic.com/images?q=tbn:ANd9GcTBQZSg-b2LFkLlt9fWndS1w8SONabDZBHf0dtdb3-bqcuKxduL",
                "title" => "1Q84",
                "author" => "Haruki Murakami",
                "year" => 2009,
                "stock" => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ];

        DB::table('books')->insert($books);
    }
}
