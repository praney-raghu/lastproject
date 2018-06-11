<?php

namespace Ssntpl\Neev\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ssntpl\Neev\Models\Organisation;
use Ssntpl\Neev\Models\User;
use Ssntpl\Neev\Facades\Neev;
use Illuminate\Support\Facades\Artisan;
use Ssntpl\Neev\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InstallController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */      

    public function index()
    {
        return view('neev::install.welcome');
    }

    /**
     * For testing Database Connection.
     *
     * @return \Illuminate\Http\Response
     */

    public function testDBConnection(Request $request)
    {   
        //return ['status' => true,'message' => 'Test']; 
        $servername = $request->host;
        $database = $request->db;
        $username = $request->username;
        $password = $request->pwd;
        try{
            $dbh = new \pdo( 'mysql:host='.$servername.';dbname='.$database,$username,$password,array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));                            
            return ['status' => true, 'message' => 'Connection successful.'];
        }
        catch(\PDOException $ex){
            return ['status' => false, 'message' => 'Unable to connect.'];                
        }
    }    

    /**
     * For completing Installation process.
     *
     * @return \Illuminate\Http\Response
     */

    public function install(Request $request)
    {
        $validator = $request->validate([
        'host' => 'required',
        'db' => 'required',
        'username' => 'required',
        'org_name' => 'required',
        'org_code' => 'required',
        'org_domain' => 'required',
        'admin_name' => 'required',
        'admin_email' => 'required|email',
        'admin_pwd' => 'required|min:6'
        ]);

                
        // Changing env file
        
        $db_host = config('database.connections.mysql.host');
        $db_name = config('database.connections.mysql.database');
        $db_user = config('database.connections.mysql.username');
        $db_password = config('database.connections.mysql.password');

        $defaults = [$db_host,$db_name,$db_user,$db_password];
        
        $data = [
            'DB_HOST'       => $request->host,
            'DB_DATABASE'   => $request->db,
            'DB_USERNAME'   => $request->username,
            'DB_PASSWORD'   => $request->db_pwd
        ];

        $content = file_get_contents(base_path() . '/.env');

        $i = 0;
        foreach ($data as $key => $value) {

            $content = str_replace($key.'='.$defaults[$i], $key.'='.$value, $content);
            $i++;
        }

        file_put_contents(base_path() . '/.env', $content);

        //To update Configuration cache after change in Environment file
        Artisan::call('config:cache');
        
        // Migrate data
        Artisan::call('migrate');        
        
        // Configure database with user data and setup permissions
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');
        // Create user permissions
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'manage_permissions']);
        Permission::create(['name' => 'impersonate']);

        // Create organisation permissions
        Permission::create(['name' => 'allow_client', 'guard_name' => 'organisation']);

        // create roles and assign existing permissions
        $role = Role::create(['name' => 'super_admin']);
        $role->givePermissionTo('manage_users');
        $role->givePermissionTo('manage_permissions');
        $role->givePermissionTo('impersonate');
        $role->save();

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo('manage_users');
        $role->givePermissionTo('manage_permissions');
        $role->givePermissionTo('impersonate');
        $role->save();
        
        //Inserting organisation data in DB
        $organisation = Organisation::create([
            'name' => $request->org_name,
            'code' => $request->org_code,
            'domain' => $request->org_domain
        ]);
        
        // $organisation->givePermissionTo('allow_client');
        // $organisation->save();

        // Inserting user data in DB
        $user = User::create([
            'owner_id' => $organisation->id,
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => bcrypt($request->admin_pwd),
        ]);
        
        $user->owner()->associate($organisation);
        //not working due to guard mismatch
        //$user->assignRole($roleAdmin); 

        $organisation->members()->save($user, [
            'is_active' => true,
            'is_default' => true
        ]);
        
        return ['status' => true, 'message' => 'Installation Successful!'];
    }
}
