<?php

namespace Dashboard\Template;

abstract class AbstractTemplate
{
    protected string $url = "";

    abstract public function generate();
    abstract public function create();
    abstract public function edit($id);
    abstract public function delete($id);
}
