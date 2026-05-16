<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class QrisSetting extends Model
{
    protected $fillable = [
        'image_path',
        'label',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (): void {
            if (static::query()->exists()) {
                throw new \RuntimeException('Hanya boleh ada satu pengaturan QRIS.');
            }
        });
    }

    public static function instance(): self
    {
        return static::query()->firstOrCreate([], [
            'is_active' => true,
        ]);
    }

    public static function activeForCheckout(): ?self
    {
        return static::query()
            ->where('is_active', true)
            ->whereNotNull('image_path')
            ->where('image_path', '!=', '')
            ->first();
    }

    public function imageUrl(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        return Storage::disk('public')->url($this->image_path);
    }
}
