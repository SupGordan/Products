<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            ['name' => "Новый заказ"],
            ['name' => "Заказ отправлен"],
            ['name' => "Заказ завершен"]
        ]);
    }
}
