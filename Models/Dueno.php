<?php

namespace Models;

class dueno extends User
{

    function __construct()
    {
        parent::__construct();
        $this->tipo = 'd';
    }
}
