<?php

namespace Ssntpl\Neev;

use Ssntpl\Neev\Models\User;
use Illuminate\Support\Facades\DB;
use Ssntpl\Neev\Models\Organisation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;

class Neev
{
    /**
     * Laravel application
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * The version of Neev.
     */
    public static $version = '0.0.1';

    /**
     * Create a new Neev instance.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function isInstalled()
    {
        // Test database connection
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return false;
        }

        if (!Schema::hasTable('organisations') || !Organisation::all()->count()) {
            return false;
        }
        return true;
    }

    public function isRegistered()
    {
        if (!$this->isInstalled() || \is_null($this->organisation())) {
            return false;
        }
        return true;
    }

    public static function organisation()
    {
        if (\App::runningInConsole()) {
            // We are running in console. Return root organisation.
            return Organisation::where('owner_id', '=', null)->first();
        } else {
            // We are running in browser. Fetch the domain from Request.
            $domain = preg_replace('#^https?://#', '', Request::root());
            $organisation = Organisation::where('domain', '=', $domain)->first();

            // Check if the organisation has permission to allow clients to access their resources via parent organisation domain.
            if ($organisation && $organisation->hasPermissionTo('allow_client') && Request::has('organisation')) {
                $client = Organisation::where('code', '=', Request::input('organisation'))->first();
                if ($organisation->clients->contains($client)) {
                    $organisation = $client;
                }
            }

            return $organisation;
        }
    }

    public function getUser($email)
    {
        $organisation = $this->organisation();
        $organisation_id = ($organisation) ? $organisation->id : null;
        return User::where('email', $email)->where('owner_id', $organisation_id)->first();
    }

    // public function config($key)
    // {
    //     $organisation = $this->organisation();

    //     return 'config value';
    // }
}
