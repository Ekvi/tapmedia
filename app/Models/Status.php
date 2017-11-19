<?php

namespace App\Models;

class Status
{
    private $id;
    private $action;
    private $isRedirect;

    public function __construct($id, $action, $isRedirect = false)
    {
        $this->id = $id;
        $this->action = $action;
        $this->isRedirect = $isRedirect;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action= $action;
    }

    public function isRedirect(): bool
    {
        return $this->isRedirect;
    }

    public function setRedirect(bool $redirect)
    {
        $this->isRedirect = $redirect;
    }
}