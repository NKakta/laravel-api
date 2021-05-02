<?php
declare(strict_types=1);

namespace Database\Seeders;

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
        $this->call(UserSeeder::class);
        $this->call(ListSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(FollowerSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(ListItemSeeder::class);
        $this->call(GameStatusSeeder::class);
    }
}
