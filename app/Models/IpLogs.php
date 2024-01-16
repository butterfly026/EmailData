<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpLogs extends Model
{
    use HasFactory, ModelTrait;
    protected $fillable = ['ip_address', 'users_id', 'method', 'try_num', 'can_download'];
}
