<?php

namespace Tests\Unit;

use App\Models\BadDomain;
use App\Models\Click;
use App\Repositories\BadDomainRepository;
use App\Repositories\ClickRepository;
use App\Services\ClickService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ClickTest extends TestCase
{
    use DatabaseTransactions;

    private $clickService;

    public function setUp()
    {
        parent::setUp();

        $this->clickService = new ClickService(new ClickRepository(new Click()), new BadDomainRepository(new BadDomain()));
    }

    public function testSuccessAddClick()
    {
        $ip = '192.168.0.1';
        $userAgent = 'Opera';
        $referer = 'http://test.com';
        $param1 = 'param1';
        $param2 = 'param2';

        $status = $this->clickService->add($ip, $userAgent, $referer, $param1, $param2);

        $this->assertEquals('success', $status->getAction());
        $this->assertEquals(false, $status->isRedirect());


        $this->assertDatabaseHas('clicks', [
            'ua' => $userAgent, 'ip' => $ip, 'param1' => $param1, 'param2' => $param2,
            'ref' => $referer, 'error' => 0, 'bad_domain' => 0
        ]);
    }

    public function testFailAddClick()
    {
        $click = factory(Click::class)->create();

        $ip = '192.168.0.1';
        $userAgent = 'Opera';
        $referer = 'http://test.com';
        $param1 = 'param1';
        $param2 = 'param2';

        $status = $this->clickService->add($ip, $userAgent, $referer, $param1, $param2);

        $this->assertEquals('error', $status->getAction());
        $this->assertEquals(false, $status->isRedirect());

        $this->assertDatabaseHas('clicks', [
            'ua' => $userAgent, 'ip' => $ip, 'param1' => $param1,
            'ref' => $referer, 'error' => $click->error + 1, 'bad_domain' => 0
        ]);
    }

    public function testSuccessAddClickWithBadDomain()
    {
        factory(BadDomain::class, 'google')->create();
        $click = factory(Click::class, 'withGoogle')->create();

        $ip = '192.168.0.1';
        $userAgent = 'Opera/8.25 (Windows NT 5.1; en-US) Presto/2.9.188 Version/10.00';
        $referer = 'http://google.com';
        $param1 = 'param1';
        $param2 = 'param2';

        $status = $this->clickService->add($ip, $userAgent, $referer, $param1, $param2);


        $this->assertEquals('error', $status->getAction());
        $this->assertEquals(true, $status->isRedirect());

        $this->assertDatabaseHas('clicks', [
            'ua' => $userAgent, 'ip' => $ip, 'param1' => $param1,
            'ref' => $referer, 'error' => $click->error + 1, 'bad_domain' => $click->bad_domain + 1
        ]);
    }
}