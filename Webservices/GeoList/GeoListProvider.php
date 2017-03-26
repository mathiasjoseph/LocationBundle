<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 30/09/16
 * Time: 09:56
 */

namespace Miky\Bundle\LocationBundle\Webservices\GeoList;


class GeoListProvider
{

    private $client;

    /**
     * GeoListProvider constructor.
     */
    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    public function getContinentList()
    {
        $response = $this->client->get('/websamples.countryinfo/CountryInfoService.wso/ListOfContinentsByName/JSON');

        $response_body = json_decode($response->getBody(), true);

        $continents = array();
        foreach ($response_body as  $c){
            $continent = array();
            $continent['name'] = $c['sName'];
            $continent['code'] = $c['sCode'];
            $continents[] = $continent;
        }
        return $continents;
    }

    public function getCountryList()
    {
        $response = $this->client->get('/rest/v1/all');

        $response_body = json_decode($response->getBody(), true);

        $countries = array();
        foreach ($response_body as  $c){
            $country = array();
            $country['name'] = $c['name'];
            $country['code'] = $c['alpha2Code'];
            $country['capital'] = $c['capital'];
            $country['subregion'] = $c['subregion'];
            $country['region'] = $c['region'];
            $country['population'] = $c['population'];
            $countries[] = $country;
        }
        return $countries;
    }

    public function getLanguageList()
    {
        $response = $this->client->get('/websamples.countryinfo/CountryInfoService.wso//ListOfLanguagesByCode/JSON');

        $response_body = json_decode($response->getBody(), true);

        $countries = array();
        foreach ($response_body as  $c){
            $country = array();
            $country['name'] = $c['sName'];
            $country['code'] = $c['sISOCode'];
            $countries[] = $country;
        }
        return $countries;
    }
}