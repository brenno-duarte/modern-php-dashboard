<?php

namespace Dashboard\Template;

interface CrudInterface
{
    public function generate();
    public function create();
    public function edit($id);
    public function delete($id);
}