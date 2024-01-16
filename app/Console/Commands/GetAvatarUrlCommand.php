<?php

namespace App\Console\Commands;

use App\Models\Marketings;
use App\Services\ReportServices;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class GetAvatarUrlCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'GetAvatarUrlCommand';

    /**
     * @var string
     */
    protected $description = 'GetAvatarUrlCommand';


    /**
     * @return int
     */
    public function handle(): int
    {
        function getWindowHref($url, $headers) {
            // Parse the tracking code from cookies.
            $trk = "bf";
            $trkInfo = "bf";
            $cookies = $headers['set-cookie'];
            foreach ($cookies as $cookie) {
                $values = explode(';', $cookie);
                if($values) {
                    foreach($values as $value) {
                        $cookieParts = explode("=", $value);
                        if ($cookieParts[0] === "trkCode") {
                            $trk = $cookieParts[1];
                            break;
                        } else if ($cookieParts[0] === "trkInfo") {
                            $trkInfo = $cookieParts[1];
                            break;
                        }
                    }
                }
            }

            if (parse_url($url, PHP_URL_SCHEME) === "http") {
                // If "sl" cookie is set, redirect to https.
                foreach ($cookies as $name => $value) {
                    if ($name === "sl" && strlen($value) > 3) {
                        return "https:" . substr($url, strlen("http:"));
                    }
                }
            }

            // Get the new domain. For international domains such as fr.linkedin.com, we convert it to www.linkedin.com
            // treat .cn similar to .com here
            $domain = parse_url($url, PHP_URL_HOST);
            if ($domain !== "www.linkedin.com" && $domain !== "www.linkedin.cn") {
                $subdomainIndex = strpos($domain, ".linkedin");
                if ($subdomainIndex !== false) {
                    $domain = "www" . substr($domain, $subdomainIndex);
                }
            }

            $originalReferer = ''; //substr($_SERVER['HTTP_REFERER'], 0, 200);

            $redirectUrl = "https://" . $domain . "/authwall?trk=" . $trk . "&trkInfo=" . $trkInfo .
                "&original_referer=" . $originalReferer .
                "&sessionRedirect=" . rawurlencode($url);

            return $redirectUrl;
        }
        $marketings = Marketings::whereNull('avatar_url')
            ->whereNotNull('linkedin_url')
            ->get();

        foreach($marketings as $marketing) {
            if($marketing->linkedin_url) {
                logger()->info($marketing->linkedin_url . " checking......");
                $client = new Client(HttpClient::create(['timeout' => 60]));

                $response = $client->request('GET', $marketing->linkedin_url, [
                    'allow_redirects' => true
                ]);
                logger()->info($client->getResponse()->getContent());
                $headers = $client->getResponse()->getHeaders();
                $newUrl = getWindowHref($marketing->linkedin_url, $headers);
                logger()->info("********* new url is $newUrl");

                $client = new Client(HttpClient::create(['timeout' => 60]));
                $response = $client->request('GET', $newUrl, [
                    'allow_redirects' => true
                ]);
                logger()->info($client->getResponse()->getContent());


                break;
                $crawler = $client->request('GET', $marketing->linkedin_url, [
                    'allow_redirects' => true
                ]);


                // $crawler = $client->waitFor('.evi-image');
                $crawler->filter('.evi-image')->each(function ($node) {
                    if($node->getNode(0)->getAttribute('src')) {
                        logger()->info("$marketing->linkedin_url avatar url is " . $node->getNode(0)->getAttribute('src'));
                        $marketing->avatar_url = $node->getNode(0)->getAttribute('src');
                    }
                });
                $marketing->save();
                logger()->info("FINISHED   " . $marketing->linkedin_url . " checking......");
                break;
            }
        }
        return CommandAlias::SUCCESS;
    }
}
