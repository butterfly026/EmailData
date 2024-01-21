<?php

namespace App\Models\Base;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use App\Models;

/**
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property boolean $is_account_proxy

 * @method static ifWhere(array $params, string $string)
 * @method static ifWhereLike(array $params, string $string)
 * @method static ifWhereIn(array $params, string $string)
 * @method static ifRange(array $params, string $string)
 * @method static create(array $array)
 * @method static unique(array $params, array $array, string $string)
 * @method static idp(array $params)
 * @method static findOrFail(int $id)
 * @method static selectRaw(string $string)
 * @method static withTrashed()

 */
class BasePayments extends Model
{
    use HasFactory, ModelTrait;

    protected $table = 'payments';
    protected string $comment = 'payments';

    protected $fillable = ['users_id', 'user_email', 'card_number', 'expiration', 'cvc', 'country', 'zipcode', 'amount', 'pay_elements', 'confirmed_at', 'order_no', 'paid_at'];

    public function user(): Relations\BelongsTo
    {
        return $this->belongsTo(Models\User::class, 'users_id', 'id');
    }
    # endregion
}
