<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(FLocationTableSeeder::class);
        $this->call(FUtcTableSeeder::class);
        $this->call(FMasterDatasSeeder::class);
        $this->call(FSensorsMasterTableSeeder::class);
        $this->call(FAgrinoteFieldSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(FOperatePermissionsSeeder::class);
        $this->call(FRolePermissionsSeeder::class);
    }
}
