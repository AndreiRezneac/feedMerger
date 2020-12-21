<?php

namespace App\Tests\Service\Provider\Xkcd;

use App\Service\Provider\Xkcd\HttpLastNumberFetcher;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpLastNumberFetcherTest extends TestCase
{
    public function testGet()
    {
        $responseBody = $this->getResponseBody();
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getContent')->willReturn($responseBody);
        $client = $this->createMock(HttpClientInterface::class);
        $client->method('request')->willReturn($response);

        $fetcher = new HttpLastNumberFetcher($client);

        $this->assertSame(614, $fetcher->fetch());
    }

    private function getResponseBody(): string
    {
        return '<html><head></head><body data-new-gr-c-s-check-loaded="14.988.0" data-gr-ext-installed="">
If you want to fetch comics and metadata automatically,<br>
you can use the JSON interface.  The URLs look like this:<br>
<br>
<a href="http://xkcd.com/info.0.json">http://xkcd.com/info.0.json</a> (current comic)<br>
<br>
or:<br>
<br>
<a href="http://xkcd.com/614/info.0.json">http://xkcd.com/614/info.0.json</a> (comic #614)<br>
<br>
Those files contain, in a plaintext and easily-parsed format: comic titles, <br>
URLs, post dates, transcripts (when available), and other metadata.<br>

</body></html>';
    }
}
