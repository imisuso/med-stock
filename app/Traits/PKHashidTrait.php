<?php
namespace App\Traits;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait PKHashidTrait {
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->findByUnhashKey($value)->firstOrFail();
    }

    public function scopeFindByUnhashKey(Builder $query, string $hashedKey): void
    {
        if(isset($hashedKey[0])){
            $query->where('id', app(abstract: Hashids::class)->decode($hashedKey)[0]);
        }

    }
    protected function hashedKey(): Attribute {
        return Attribute::make(
            get: fn () => app(abstract: Hashids::class)->encode($this->attributes['id']),
        );
    }
}
