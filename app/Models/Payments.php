<?php

namespace App\Models;

use App\Models\Base\BasePayments;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends BasePayments
{
    use HasFactory, ModelTrait;
}
