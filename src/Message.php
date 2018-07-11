<?php

namespace App;

interface Message
{
    public function toArray();

    public function getApiEndpoint();
}