<?php

namespace App\Service\Provider\Xkcd;

interface XkcdLastNumberFetcher
{
    public function fetch(): int;
}