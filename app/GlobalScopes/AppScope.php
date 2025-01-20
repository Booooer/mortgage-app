<?php

namespace App\GlobalScopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AppScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $attr = 'app_id';
        if (! empty(auth()->user())) {
            if (method_exists($model, 'getAppAttr')) {
                $attr = $model->getTable() . '.' . $model::getAppAttr();
            }
            $builder->where([$attr => auth()->user()->app_id]);
        } else {
            $builder->where([$attr => 1]);
        }
    }
}
