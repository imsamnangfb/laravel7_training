<?php

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatePostTableSeeder extends Seeder
{
    public function run()
    {
        // reset the posts table
        DB::table('posts')->truncate();

        // generate 20 dummy posts data
        $posts = [];
        $faker = Factory::create();
        $date = Carbon::create(2019, 9, 25, 9);

        for ($i = 1; $i <= 20; $i++)
        {
            $image = "Post_Image_" . rand(1, 5) . ".jpg";
            $date->addDays(1);
            $publishedDate = clone($date);
            $createdDate = clone($date);

            $posts[] = [
                'user_id' => rand(1, 2),
                'title' => $faker->sentence(rand(8, 12)),
                // 'excerpt' => $faker->text(rand(250, 300)),
                'slug' => $faker->slug(),
                'image' => rand(0, 1) == 1 ? $image : 'default.png',
                'body' => $faker->paragraphs(rand(2, 5), true),
                'view_count' => rand(1,10) * 10,
                'status' => rand(0,1),
                'is_approved' => rand(0,1),
                'created_at' => $createdDate,
                'updated_at' => $createdDate,
                // 'published_at' => $i < 8 ? $publishedDate : (rand(0,1) == 0) ? NULL : $publishedDate->addDays(4),
                // 'category_id' => rand(1,5),
            ];
        }
        DB::table('posts')->insert($posts);

        // category_post
        DB::table('category_posts')->truncate();
        for ($i = 1; $i <= 6; $i++)
        {
            $cat_posts[] = [
                'post_id' => $i,
                'category_id' => rand(1,2)
            ];
        }
        DB::table('category_posts')->insert($cat_posts);


        DB::table('post_tags')->truncate();
        for ($i = 1; $i <= 6; $i++)
        {
            $post_Tag[] = [
                'post_id' => $i,
                'tag_id' => rand(1,8)
            ];
        }
        DB::table('post_tags')->insert($post_Tag);
    }
}
