<?php

namespace App\Models\Traits;

use App\Models\Model;
use App\Utils\UniqueCodes;
use Illuminate\Support\Str;

trait HasUuidWithSlug
{
    public const SLUG_MAX_LENGTH = 5;

    public const UC_OBFUSCATING_PRIME = 113379900;
    public const UC_MAX_PRIME = 28629150;
    public const UC_CHARACTERS = 'GJMKPTBSYAFRELVXCWUZHND75863924';

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            /** @var Model $model */
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
            if (empty($model->slug)) {
                $model->slug  = (new UniqueCodes())
                    ->setObfuscatingPrime(static::UC_OBFUSCATING_PRIME)
                    ->setMaxPrime(static::UC_MAX_PRIME)
                    ->setCharacters(static::UC_CHARACTERS)
                    ->setLength(static::SLUG_MAX_LENGTH)
                    ->generate($model::count() + 1, null, true);
            }
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'uuid';
    }
}
