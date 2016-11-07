<?php

namespace MicheleCurletta\LaravelCloudflarePurge;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Crypt;

class CloudflarePurgeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloudflare-cache:purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Cloudflare cache (purge it at all!)';

    private $apiEndpoint = "https://api.cloudflare.com";

    private $email = null;
    private $apiKey = null;
    private $zoneName = null;

    private $client = null; 

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->email = config('laravel-cloudflare-purge.email');
        $this->apiKey = config('laravel-cloudflare-purge.api_key');
        $this->zoneName = config('laravel-cloudflare-purge.zone_name');

        $this->client = new Client;
    }

    /**
     * Execute the console command.
     * 
     * DELETE /zones/:identifier/purge_cache
     *
     * @return mixed
     */
    public function handle()
    {

        $zoneId = $this->retrieveZoneId();

        $this->purgeZone($zoneId);

    }

    private function retrieveZoneId()
    {        
        $request = $this->client->createRequest('GET', $this->apiEndpoint, [
            'headers' => [
                            'X-Auth-Email'  => $this->email,
                            'X-Auth-Key'    => $this->apiKey
                        ]
        ]);

        $request->setPath('client/v4/zones');

        $requestQuery = $request->getQuery();
        $requestQuery->set('name', $this->zoneName);
        $requestQuery->set('status', 'active');
        $requestQuery->set('match', 'all');

        $response = $this->client->send($request);

        if(($zoneId = $response->json()['result'][0]['id']))
        {
            $this->line('Zone id: '.$zoneId);
            return $zoneId;
        }
        else
            $this->line('Ooops! Errors: '.$response->json()['errors']);
    }

    private function purgeZone($zoneId)
    {
        $request = $this->client->createRequest('DELETE', $this->apiEndpoint, [
            'headers' => [
                            'X-Auth-Email'  => $this->email,
                            'X-Auth-Key'    => $this->apiKey
                        ],
            'json' => ['purge_everything' => true]
        ]);

        $request->setPath('client/v4/zones/'.$zoneId.'/purge_cache');

        $response = $this->client->send($request);

        if(($response->json()['success']))
            $this->line('So far, so good. CDN purged!');
        else
            $this->line('Ooops! Errors: '.$response->json()['errors']);
    }
}
