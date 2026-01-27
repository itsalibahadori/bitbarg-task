<?php

namespace App\Enums\V1;

enum TaskEnums: int
{
    case PENDING = 0;
    case COMPLETED = 1;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'PENDING',
            self::COMPLETED => 'COMPLETED',
        };
    }

    public static function fromLabel($value): self
    {
        if ($value instanceof self) {
            $value = $value->name;
        }

        return match ($value) {
            'PENDING' => self::PENDING,
            'COMPLETED' => self::COMPLETED,
        };
    }

    public static function allowedForUpdate(): array
    {
        return [self::PENDING->name, self::COMPLETED->name];
    }
}
