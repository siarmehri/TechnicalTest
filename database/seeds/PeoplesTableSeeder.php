<?php

use Illuminate\Database\Seeder;
use App\Models\People;

class PeoplesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        People::create([
            'firstname'=>'Jo',
            'lastname' => 'Strummer',
            'email' => 'mail+j+strummer@9xb.com',
            'job_role' => 'Developer'
        ]);

        People::create([
            'firstname'=>'Mick',
            'lastname' => 'Jones',
            'email' => 'mail+m+jones@9xb.com',
            'job_role' => 'Project Manager'
        ]);

        People::create([
            'firstname'=>'Pauline',
            'lastname' => 'Black',
            'email' => 'mail+p+black@9xb.com',
            'job_role' => 'Developer'
        ]);

        People::create([
            'firstname'=>'Topper',
            'lastname' => 'Headon',
            'email' => 'mail+t+headon@9xb.com',
            'job_role' => 'Developer'
        ]);
    }
}
