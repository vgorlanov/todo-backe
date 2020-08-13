<?php

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $project = new \App\Project();
            $project->title = $faker->text(random_int(10, 25));
            $project->user_id = random_int(1, 10);
            $project->save();

            for ($j = 0; $j < random_int(1, 10); $j++){

                $taskArr = [
                    'user_id' => $project->user_id,
                    'project_id' => random_int(0, 1) ? $project->id : null,
                    'title'   => $faker->text(random_int(10, 25)),
                    'body'    => $faker->text,
                    'done'    => random_int(0, 1),
                    'date'    => $faker->dateTime(),
                ];

                \App\Task::create($taskArr);
            }
        }
    }
}
