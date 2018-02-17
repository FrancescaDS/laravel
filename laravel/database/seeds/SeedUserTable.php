<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User;

class SeedUserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //chiamo la factory per popolare la tabella invece di farlo direttamente qui
        factory(App\Models\User::class, 30)->create();

        /* $sql = 'INSERT INTO users (name, email, password, created_at)
values (:name, :email, :password, :created_at)';
        for($i=0;$i<31; $i++) {
            DB::statement($sql, [
                'name' => 'Francesca'.$i,
                'email' => $i.'francesca.dallaserra@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now() //date(Y-m-d H:i:s')
            ]);
        }*/


    }
}
