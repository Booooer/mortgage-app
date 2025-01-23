<?php

namespace App\Traits;

use App\GlobalScopes\AppScope;
use App\Interfaces\HasAppInterface;
use DomDev\B24LaravelApp\Models\B24Install;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAppTrait
{
    public static function bootHasAppTrait(): void
    {
        static::addGlobalScope(new AppScope());

        static::creating(function ($model) {
            $appAttr = $model->getAppAttr();
            $model->$appAttr ??= auth()->user()->app_id;
        });
    }

    public static function getAppAttr(): string
    {
        return self::$appAttr ?? 'app_id';
    }

    public function app(): BelongsTo
    {
        return $this->belongsTo(B24Install::class, self::getAppAttr());
    }

    public function scopeByApp($query, $appId): void
    {
        $appAttr = self::getAppAttr();
        $query->withoutGlobalScopes()->where([$appAttr => $appId]);
    }
}
