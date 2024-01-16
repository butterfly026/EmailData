<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketings extends Model
{
    use HasFactory, ModelTrait;
    protected $fillable = ['first_name', 'last_name', 'email', 'linkedin_url', 'title', 'company', 'domain', 'city', 'avatar_url', 'state', 'country', 'industry'];
}
