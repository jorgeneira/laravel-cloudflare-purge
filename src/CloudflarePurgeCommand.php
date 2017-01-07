<?php

namespace MicheleCurletta\LaravelCloudflarePurge;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

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
	    $request = $this->client->request('GET', "{$this->apiEndpoint}/client/v4/zones", [
            'headers' => [
                            'X-Auth-Email'  => $this->email,
                            'X-Auth-Key'    => $this->apiKey
                        ],
            'query' => [
			                'name' => $this->zoneName,
			                'status' => 'active',
				            'match' => 'all'
			            ],
        ]);

	    $response = json_decode($request->getBody(), true);

        if(($zoneId = $response['result'][0]['id']))
        {
            $this->line('Zone id: '.$zoneId);
            return $zoneId;
        }
        else
            $this->line('Ooops! Errors: '.$response['errors']);
    }

    private function purgeZone($zoneId)
    {
	    $request = $this->client->request('DELETE', "{$this->apiEndpoint}/client/v4/zones/{$zoneId}/purge_cache", [
            'headers' => [
                            'X-Auth-Email'  => $this->email,
                            'X-Auth-Key'    => $this->apiKey
                        ],
            'json' => ['purge_everything' => true]
        ]);

	    $response = json_decode($request->getBody(), true);

        if(($response['success']))
            $this->line('So far, so good. CDN purged!');
        else
            $this->line('Ooops! Errors: '.$response['errors']);
    }
}
