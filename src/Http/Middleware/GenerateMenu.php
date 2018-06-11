<?php

namespace Ssntpl\Neev\Http\Middleware;

use Closure;
use App;
use Config;

class GenerateMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Create Admin Menu with default fields
        \Menu::make('AdminMenu', function ($menu) {
            $menu->add('Dashboard', ['route' => 'admin.home']);
                $menu->get('dashboard')->prepend('<i class="fa fa-dashboard"></i><span class="title">')->append('</span>');

            $menu->add('User Management')->nickname('userManagement')
                ->prepend('<i class="fa fa-wrench"></i><span class="title">')->append('</span>');
                                                   
            $menu->item('userManagement')->add('Users', ['route' => 'admin.users.index'])
                ->prepend('<i class="fa fa-users"></i><span class="title">')->append('</span>');                
            $menu->item('userManagement')->add('Clients', ['route' => 'admin.clients.index'])
                ->prepend('<i class="fa fa-user"></i><span class="title">')->append('</span>');

            // Admin > System preferences
            $menu->add('System Preferences')->nickname('systemPreferences')
                ->prepend('<i class="fa fa-gear"></i><span class="title">')->append('</span>')->link->href('#');
            
            $menu->item('systemPreferences')->add('Permissions', ['route' => 'admin.permissions.index'])
                ->prepend('<i class="fa fa-briefcase"></i><span class="title">')->append('</span>');
            
            $menu->item('systemPreferences')->add('Roles', ['route' => 'admin.roles.index'])
                ->prepend('<i class="fa fa-briefcase"></i><span class="title">')->append('</span>');

            $menu->item('systemPreferences')->add('Translations', ['route' => 'admin.translation.index'])
                ->prepend('<i class="fa fa-wrench"></i><span class="title">')->append('</span>');

            $menu->item('systemPreferences')->add('API Tokens', ['route' => 'admin.tokens.index'])
                ->prepend('<i class="fa fa-gear"></i><span class="title">')->append('</span>');

            $menu->item('systemPreferences')->add('Module Management', ['route' => 'admin.modules.index'])
                ->prepend('<i class="fa fa-gear"></i><span class="title">')->append('</span>');            
        });



        \Menu::make('UserMenu', function ($menu) {
            $menu->add('Dashboard', ['route' => 'user.home']);
            $menu->get('dashboard')->prepend('<i class="fa fa-dashboard"></i><span class="title">')->append('</span>');

            $menu->add('Account Settings')->nickname('accountSettings')
                ->prepend('<i class="fa fa-laptop"></i><span class="title">')->append('</span>')->link->href('#');

            $menu->item('accountSettings')->add('Profile', ['route' => 'user.profile'])
                ->prepend('<i class="fa fa-user"></i><span class="title">')->append('</span>');
            $menu->item('accountSettings')->add('Change Password', ['route' => 'user.change_password'])
                ->prepend('<i class="fa fa-key"></i><span class="title">')->append('</span>');
            $menu->item('accountSettings')->add('Organisations', ['route' => 'organisation.index'])
                ->prepend('<i class="fa fa-user"></i><span class="title">')->append('</span>');
                        
            $menu->add('Languages', ['route' => 'language.index'])
                ->prepend('<i class="fa fa-wrench"></i><span class="title">')->append('</span>');
        });

        \Menu::make('ClientMenu', function ($menu) {
            $menu->add('Dashboard', ['route' => 'organisation.home']);
            $menu->get('dashboard')->prepend('<i class="fa fa-dashboard"></i><span class="title">')->append('</span>');            
        });
        return $next($request);
    }
}
