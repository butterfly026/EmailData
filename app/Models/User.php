<?php

namespace App\Models;
use App\Models\Base\BaseUsers;
use App\Traits\ModelTrait;
use Laravel\Sanctum\HasApiTokens;


class User extends BaseUsers
{
    use HasApiTokens, ModelTrait;
}
