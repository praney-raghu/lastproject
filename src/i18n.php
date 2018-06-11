<?php

namespace Ssntpl\Neev;

use Jenssegers\Agent\Agent;
use Ssntpl\Neev\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use PragmaRX\Countries\Package\Countries;

class i18n
{
    /**
     * Laravel application
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Create a new Neev instance.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    //private $storagePath;

    private $geoIP2reader;
    private function geoIP2reader() {
        if(!isset($this->geoIP2reader)) {
            $storagePath = \Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . 'GeoIP/GeoLite2-Country.mmdb';
            if(!file_exists($storagePath)) {
                $url = "http://geolite.maxmind.com/download/geoip/database/GeoLite2-Country.tar.gz";
                // TODO: download the extracted file to $storagePath
            }
            $this->geoIP2reader = new \GeoIp2\Database\Reader($storagePath);
        }
        return $this->geoIP2reader;
    }

    private $ip;
    public function ip() {
        if(!isset($this->ip)) {
            $this->ip = Request::ip();
        }
        return $this->ip;
    }

    private $agent;
    public function agent() {
        if(!isset($this->agent)) {
            $this->agent = new Agent();
        }
        return $this->agent;
    }

    public function countryIsoCode($ip = null)
    {
        try {
            $record = $this->geoIP2reader()->country(($ip)?:$this->ip()); // eg. '182.69.82.9' would return IN
            $userCountryIsoCode = $record->country->isoCode;
        } catch (\Exception $e) {
            $userCountryIsoCode = null;
        }

        return $userCountryIsoCode;
    }

    public function country($ip = null)
    {
        try {
            $record = $this->geoIP2reader()->country(($ip)?:$this->ip()); 
            $country = Countries::where('cca2', $record->country->isoCode)->first();//->hydrateCurrencies()->currencies->INR->coins->frequent->first();
        } catch (\Exception $e) {
            $country = null;
        }

        return $country;
    }

    public function rate()
    {
        return \Swap::latest('USD/INR')->getValue();
    }

}
