<?php

declare(strict_types=1);

namespace MyParcelCom\Integration\Order\Items;

use JetBrains\PhpStorm\ArrayShape;

class Feature
{
    public function __construct(
        private readonly string $key,
        private readonly string|int|float|bool $value,
        private readonly ?Annotation $annotation = null,
    ) {
    }

    #[ArrayShape(['key' => 'string', 'value' => 'string|int|float|bool', 'annotation' => 'string|null'])]
    public function toArray(): array
    {
        return array_filter([
            'key'        => $this->key,
            'value'      => $this->value,
            'annotation' => $this->annotation?->value,
        ], [$this, 'isNotNull']);
    }

    private function isNotNull($value): bool
    {
        return $value !== null;
    }
}
