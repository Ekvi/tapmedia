<?php

namespace App\Services;

use App\Models\BadDomain;
use App\Repositories\BadDomainRepository;

class BadDomainService
{
    private $badDomainRepository;

    public function __construct(BadDomainRepository $badDomainRepository)
    {
        $this->badDomainRepository = $badDomainRepository;
    }

    public function getAll()
    {
        return $this->badDomainRepository->all();
    }

    public function add($name) {

        $badDomain = BadDomain::create($name);
        $this->badDomainRepository->save($badDomain);
    }

    public function get($id)
    {
        return $this->badDomainRepository->one(['id' => $id]);
    }

    public function update($id, $name)
    {
        /**  @var $domain \App\Models\BadDomain */
        $domain = $this->get($id);

        $domain->changeName($name);
        $this->badDomainRepository->update($domain);
    }

    public function delete($id)
    {
        $this->badDomainRepository->delete($id);
    }
}