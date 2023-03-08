<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i=0; $i<10; $i++){
            $newProject = new Project();
            $newProject->title = $faker->sentence(2);
            $newProject->description = $faker->text(400);
            $newProject->slug = Str::slug($newProject->title, '-');
            $newProject->save();
        }
    }
}
