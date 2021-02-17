<?php

namespace Markese\Datatables;
use Psr\Http\Message\ServerRequestInterface as Request;

interface DTBuilder
{
    public function buildDT(): DTResponse;
}
