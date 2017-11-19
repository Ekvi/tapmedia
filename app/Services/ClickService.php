<?php

namespace App\Services;

use App\Models\Click;
use App\Models\Status;
use App\Repositories\BadDomainRepository;
use App\Repositories\ClickRepository;

class ClickService
{
    private $clickRepository;
    private $badDomainRepository;

    public function __construct(ClickRepository $clickRepository, BadDomainRepository $badDomainRepository)
    {
        $this->clickRepository = $clickRepository;
        $this->badDomainRepository = $badDomainRepository;
    }

    public function findById($id)
    {
        return $this->clickRepository->one(['id' => $id]);
    }

    public function search($params)
    {
        $searchColumn = !empty($params['searchColumn']) ? $params['searchColumn'] : '';
        $searchInput = !empty($params['searchInput']) ? $params['searchInput'] : '';

        return $this->clickRepository->search($params['column'], $params['direction'], $searchColumn, $searchInput);
    }

    public function add($ip, $userAgent, $referer, $param1, $param2)
    {
        $badDomain = $this->badDomainRepository->one(['name' => $referer]);
        $click = $this->findByRequest($ip, $userAgent, $referer, $param1);

        $badDomainCount = !empty($badDomain) ? 1 : 0;

        return $this->createOrUpdate(
            $click, $ip, $userAgent, $referer, $param1, $param2, $badDomainCount);
    }

    private function findByRequest($ip, $userAgent, $referer, $param1)
    {
        $where = ['ip' => $ip, 'ua' => $userAgent, 'ref' => $referer, 'param1' => $param1];

        return $this->clickRepository->one($where);
    }

    private function createOrUpdate($click, $ip, $userAgent, $referer, $param1, $param2, $badDomain = 0)
    {
        if(empty($click)) {
            return $this->create($ip, $userAgent, $referer, $param1, $param2);
        } else {
            $error = 1;
            return $this->update($click, $error, $badDomain);
        }
    }

    private function create($ip, $userAgent, $referer, $param1, $param2)
    {
        $click = Click::create($ip, $userAgent, $referer, $param1, $param2);
        $this->clickRepository->save($click);

        return new Status($click->id, 'success');
    }

    private function update(Click $click, $error, $badDomain = 0)
    {
        $click->error += $error;
        $click->bad_domain += $badDomain;
        $this->clickRepository->update($click);

        $isRedirect = $badDomain ? true : false;

        return new Status($click->id, 'error', $isRedirect);
    }

    public function delete($id)
    {
        return $this->clickRepository->delete($id);
    }
}