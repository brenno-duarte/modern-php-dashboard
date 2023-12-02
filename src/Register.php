<?php

namespace Dashboard;

use Katrina\Katrina;

class Register extends Katrina
{
    protected ?string $table = "users";
    //protected ?string $id = "id_user";
    protected bool $timestamp = false;
}
