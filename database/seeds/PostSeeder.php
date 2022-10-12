<?php

use App\Admin\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i=0; $i<5; $i++) {
            $newPost = new Post();

            $newPost->slug = $faker->word();
            $newPost->title = $faker->word();
            $newPost->description = $faker->paragraph();
            $newPost->save();
        }
    }
}
