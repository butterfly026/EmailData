<?php

namespace App\Traits;


use App\Models\Users;
use Carbon\Carbon;
use Closure;
use DateTimeInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 *
 */
trait ModelTrait
{
    /**
     * @param Builder $builder
     * @param string $field
     * @param Carbon $now
     * @return Builder
     */
    public function scopeWhereDay(Builder $builder, string $field, Carbon $now): Builder
    {
        return $builder->whereRaw("DATE($field) = '{$now->toDateString()}'");
    }

    /**
     * @param Builder $builder
     * @param string $day
     * @param string $field
     * @return Builder
     */
    public function scopeToday(Builder $builder, string $day, string $field = 'day'): Builder
    {
        return $builder->where($field, $day);
    }


    /**
     * @param array $params1
     * @param array $params2
     * @return int
     */
    public static function updateOrCreate(array $params1, array $params2): int
    {
        $model = self::where($params1)->first();
        if ($model) {
            $model->update($params2);
            return 1;
        } else {
            self::create([
                ...$params1,
                ...$params2
            ]);
            return 2;
        }
    }


    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeDescID(Builder $query): Builder
    {
        return $query->orderByDesc('id');
    }

    /**
     * @param Builder $query
     * @param array $params
     * @param string $key
     * @param string $relationName
     * @param Closure $closure
     * @return Builder
     */
    public function scopeIfWhereHas(Builder $query, array $params, string $key, string $relationName, Closure $closure): Builder
    {
        return $query->when(isset($params[$key]), function ($query) use ($relationName, $closure) {
            return $query->whereHas($relationName, $closure);
        });
    }

    /**
     * @param Builder $query
     * @param array $params
     * @param string $key
     * @param string $field
     * @return Builder
     */
    public function scopeIfWhereAtNotNull(Builder $query, array $params, string $key, string $field = ''): Builder
    {
        if (isset($params[$key])) {
            $field = ($field == '') ? $key : $field;
            return $params[$key] ? $query->whereNotNull($field) : $query->whereNull($field);
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param array $params
     * @param string $key
     * @param string $field
     * @return Builder
     */
    public function scopeIfWhere(Builder $query, array $params, string $key, string $field = ''): Builder
    {
        if (isset($params[$key])) {
            $field = ($field == '') ? $key : $field;
            return $query->where($field, $params[$key]);
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param array $params
     * @param string $key
     * @param string $field
     * @return Builder
     * @throws Err
     */
    public function scopeIfWhereIn(Builder $query, array $params, string $key, string $field = ''): Builder
    {
        if (isset($params[$key])) {
            if (!is_array($params[$key]))
                throw new Exception(__("The params of IfWhereIn need be a array"));
            $field = ($field == '') ? $key : $field;
            return $query->whereIn($field, $params[$key]);
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param array $params
     * @param string $key
     * @param string $field
     * @return mixed
     */
    public function scopeIfWhereLike(Builder $query, array $params, string $key, string $field = ''): Builder
    {
        if (isset($params[$key])) {
            $field = ($field == '') ? $key : $field;
            return $query->where($field, 'like', "%$params[$key]%");
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param array $params
     * @param string $key
     * @param string $field
     * @return mixed
     */
    public function scopeWhereLike(Builder $query, string $value, string $field): Builder
    {
        if ($value && $field) {
            return $query->where($field, 'like', "%$value%");
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param array $params
     * @param string $key
     * @param string $field
     * @return mixed
     */
    public function scopeOrWhereLike(Builder $query, string $value, string $field): Builder
    {
        if ($value && $field) {
            return $query->orWhere($field, 'like', "%$value%");
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param array $params
     * @param string $key
     * @param string $field
     * @param string $type
     * @param string $op1
     * @param string $op2
     * @return Builder
     * @throws Err
     */
    public function scopeIfRange(Builder $query, array $params, string $key, string $field = '', string $type = 'datetime', string $op1 = '<', string $op2 = '>='): Builder
    {
        if (isset($params[$key])) {
            $field = ($field == '') ? $key : $field;
            $a = $params[$key];

            if (is_array($a) && count($a) != 2)
                throw new Exception(__('The params of IfRange need be a array'));

            // 数据类型
            if ($type == 'date') {
                $a[0] = $a[0] == "" ? "" : Carbon::parse($a[0])->toDateString();
                $a[1] = $a[1] == "" ? "" : Carbon::parse($a[1])->toDateString();
            } elseif ($type == 'datetime') {
                $a[0] = $a[0] == "" ? "" : Carbon::parse($a[0])->toDateTimeString();
                $a[1] = $a[1] == "" ? "" : Carbon::parse($a[1])->toDateTimeString();
            } elseif ($type == 'start_end_datetime') {
                $a[0] = $a[0] == "" ? "" : Carbon::parse($a[0])->startOfDay()->toDateTimeString();
                $a[1] = $a[1] == "" ? "" : Carbon::parse($a[1])->endOfDay()->toDateTimeString();
            } elseif ($type == 'date_or_time') {
                $a[0] = $a[0] == "" ? "" : Carbon::parse($a[0])->toDateTimeString();
                $a[1] = $a[1] == "" ? "" : Carbon::parse(date('Y-m-d 23:59:59', strtotime($a[1])))->toDateTimeString();
            } else {
                $a[0] = $a[0] == "" ? "" : floatval($a[0]);
                $a[1] = $a[1] == "" ? "" : floatval($a[1]);
            }

            // 判断逻辑
            if ($a[0] == "" && $a[1] == "")
                return $query;
            else if ($a[0] == "")
                return $query->where($field, $op1, $a[1]);
            else if ($a[1] == "")
                return $query->where($field, $op2, $a[0]);
            else
                return $query->whereBetween($field, $a);
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param string $key
     * @return Builder
     */
    public function scopeOrder(Builder $query, string $key = 'orderBy'): Builder
    {
        $params = request()->only($key);
        if (isset($params[$key])) {
            $orderBy = $params[$key];
            if (count($orderBy) == 2) {
                if ($orderBy[1] == 'descend') {
                    return $query->orderBy($orderBy[0], 'desc');
                } elseif ($orderBy[1] == 'ascend') {
                    return $query->orderBy($orderBy[0]);
                }
            }
        }
        return $query->orderByDesc('id');
    }

    /**
     * @param Builder $query
     * @param array $params
     * @param array $keys
     * @param string $field
     * @param string|null $label
     * @param bool $softDelete
     * @return Builder
     * @throws Err
     */
    public function scopeUnique(Builder $query, array $params, array $keys, string $label = null, bool $softDelete = false, string $field = 'id'): Builder
    {
        $data = Arr::only($params, $keys);
        if ($softDelete)
            $model = $query->withTrashed()->where($data)->first();
        else
            $model = $query->where($data)->first();
        if ($model && $label != null) {
            if (!isset($params[$field]) || $model->$field != $params[$field])
                throw new Exception("{$label}【{$params[$keys[0]]}】is exists");
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param array $params
     * @param string $key
     * @param string $field
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function scopeIdp(Builder $query, array $params, string $key = 'id', string $field = 'id'): Model|Collection|Builder|array|null
    {
        return $query->findOrFail($params[$key]);
    }

    /**
     * @param Builder $query
     * @param string $selectRaw
     * @return Builder
     */
    public function scopeWithSoftDeleted(Builder $query, string $selectRaw): Builder
    {
        $arr = explode(':', $selectRaw);
        return $query->with([$arr[0] => function ($q) use ($arr) {
            $q->withTrashed()->selectRaw($arr[1]);
        }]);
    }

    /**
     * @param $keys
     * @param $params
     * @param null $errMessage
     * @return bool
     * @throws Err
     */
    public static function CheckUnique($keys, $params, $errMessage = null): bool
    {
        $where = Arr::only($params, $keys);
        $model = self::where($where)->first();
        if (!$model) {
            return true;
        } else {
            if ($errMessage != null)
                throw new Exception($errMessage);
            return false;
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws Err
     */
    public static function findOrError($id): mixed
    {
        $model = self::find($id);
        if (!$model)
            throw new Exception("no【" . self::$name . "】record");
        return $model;
    }

    /**
     * @param DateTimeInterface $dateTime
     * @return string
     */
    public function serializeDate(DateTimeInterface $dateTime): string
    {
        return $dateTime->format('Y-m-d H:i:s');
    }

    /**
     * @param Builder $query
     * @param array $pop 需要排除的字段数组
     * @param array $push 需要增加的字段数组
     * @return Builder
     */
    public function scopeUnSelect(Builder $query, array $pop = [], array $push = []): Builder
    {
        $fields = array_merge(['id'], $this->fillable, $push);
        $fields = array_diff($fields, $pop);
        return $query->select($fields);
    }

    /**
     * @param Builder $query
     * @param string $popStr 需要排除的字段字符串，不要空格，逗号隔开
     * @param string $pushStr 需要增加的字段字符串，不要空格，逗号隔开
     * @return Builder
     */
    public function scopeUnSelectRaw(Builder $query, string $popStr = '', string $pushStr = ''): Builder
    {
        $pop = explode(',', $popStr);
        $push = explode(',', $pushStr);
        $fields = array_merge(['id'], $this->fillable, $push);
        $fields = array_diff($fields, $pop);
        return $query->select($fields);
    }

    /**
     * @param $query
     * @param $params
     * @param $page
     * @param $pageSize
     * @return mixed
     */
    public function scopeDownload($query, $params, $page, $pageSize): mixed
    {
        $type = $params['download_type'];
        if ($type == 1) {
            return $query->forPage($page, $pageSize);
        } else {
            return $query;
        }
    }
}

