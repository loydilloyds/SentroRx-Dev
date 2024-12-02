<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Http;

class Address extends Model
{
    private string $url = "https://psgc.cloud/api/";

    protected $fillable = [
        'region',
        'province',
        'city',
        'barangay',
    ];

    private function checkConnection(string $url) : bool
    {
        if ($url == null || trim($url) === '') {
            return false;
        }

        return Http::get($url)->ok();
    }

    private function getApiResponse(string $url)
    {
        return Http::get($url)->json();
    }

    public function health_centers() : HasMany
    {
        return $this->hasMany(HealthCenter::class);
    }

    public function getAllRegions(string $code = '')
    {
        $url = $this->url . "regions/" . $code;

        if ($code === null || !$this->checkConnection($url))
        {
            return response('This region cannot be found');
        }

        return $this->getApiResponse($url);
    }

    public function getAllProvinces()
    {
        $url = $this->url . "regions/" . $this->region .  "/provinces";

        if (!$this->checkConnection($url))
        {
            return response('This region cannot be found');
        }

        return $this->getApiResponse($url);
    }

    public function getAllCities()
    {
        $url = $this->url . "/provinces/" . $this->province .  "/cities";

        if ($this->region === '1300000000')
            $url = $this->url . "regions/" . $this->region . "/cities";

        if (!$this->checkConnection($url))
        {
            return response('This province cannot be found');
        }

        return $this->getApiResponse($url);
    }

    public function getAllBarangays()
    {
        $url = $this->url . "cities/" . $this->city .  "/barangays";
        print($url);

        if (!$this->checkConnection($url))
        {
            return response('This city cannot be found');
        }

        return $this->getApiResponse($url);
    }

}
