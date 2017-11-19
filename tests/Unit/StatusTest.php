<?php

namespace Tests\Unit;

use App\Models\BadDomain;
use App\Models\Click;
use App\Repositories\BadDomainRepository;
use App\Repositories\ClickRepository;
use App\Services\ClickService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use DatabaseTransactions;

    private $clickService;

    public function setUp()
    {
        parent::setUp();

        $this->clickService = new ClickService(new ClickRepository(new Click()), new BadDomainRepository(new BadDomain()));
    }

    private function makeRequest()
    {
        $response = $this->call(
            'GET',
            '/click?param1=param1&param2=param2',
            [],
            [],
            [],
            [
                'HTTP_REFERER' => 'http://tapmedia.dev',
                'HTTP_USER_AGENT' => 'Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0'
            ]
        );

        return $response;
    }

    public function testSuccessStatus()
    {
        $response = $this->makeRequest();

        $response->assertStatus(302);
        $response->assertSessionHas('isRedirect', $value = null);
        $this->assertTrue(str_contains($response->headers->get('Location'), 'success'));
    }

    public function testErrorStatus()
    {
        factory(Click::class, 'statusTest')->create();

        $response = $this->makeRequest();

        $response->assertStatus(302);
        $response->assertSessionHas('isRedirect', $value = null);
        $this->assertTrue(str_contains($response->headers->get('Location'), 'error'));
    }

    public function testErrorStatusWithRedirect()
    {
        factory(BadDomain::class, 'tapmedia')->create();
        factory(Click::class, 'statusTest')->create();

        $response = $this->makeRequest();

        $response->assertStatus(302);
        $response->assertSessionHas('isRedirect', true);
        $this->assertTrue(str_contains($response->headers->get('Location'), 'error'));
    }
}