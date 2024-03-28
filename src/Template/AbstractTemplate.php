<?php

namespace Dashboard\Template;

abstract class AbstractTemplate
{
    protected string $url = "";

    abstract public function generate();
}
