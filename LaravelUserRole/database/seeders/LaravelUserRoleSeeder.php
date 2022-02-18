<?php
namespace Phonglg\LaravelUserRole\Database\Seeders; 

 
use Phonglg\LaravelUserRole\Models\User;
use Phonglg\LaravelUserRole\Models\Role; 
use Illuminate\Database\Seeder;  
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Str;

class LaravelUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {  
        //create roles for user
        $roles = config('laraveluserrole.roles');
        foreach($roles as $no => $roleName){
            $role=Role::create([ 
                'id' => ($no+1),
                'name' => $roleName,
                'slug' => Str::slug($roleName),
                'permissions' => '[]',
            ]);
        }  

        //create SupperUser, have id=1
        $fields=[
            'id' => 1,
            'role_id' => 1,
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '1234',
        ];
        $fields['password'] = Hash::make($fields['password']); 
        User::create($fields); 

        //create User employee
        for($i=2;$i<=5;$i++){
            $fields=[
                'id' => $i,
                'role_id' => 2,
                'name' => 'user'.$i,
                'username' => 'user'.$i,
                'email' => 'user'.$i.'@gmail.com',
                'password' => '1234',
            ];
            $fields['password'] = Hash::make($fields['password']); 
            User::create($fields); 
        }

        //create User customer
        for($i=6;$i<=10;$i++){
            $fields=[
                'id' => $i,
                'role_id' => 3,
                'name' => 'customer'.$i,
                'username' => 'customer'.$i,
                'email' => 'customer'.$i.'@gmail.com',
                'password' => '1234',
            ];
            $fields['password'] = Hash::make($fields['password']); 
            User::create($fields); 
        }
    } 
}