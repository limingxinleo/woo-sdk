<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Woo;

function int_or_null(mixed $value): ?int
{
    if ($value === null) {
        return null;
    }

    return (int) $value;
}

function string_or_null(mixed $value): ?string
{
    if ($value === null) {
        return null;
    }

    return (string) $value;
}

function bool_or_null(mixed $value): ?bool
{
    if ($value === null) {
        return null;
    }

    return (bool) $value;
}

function array_or_null(mixed $value): ?array
{
    if (is_array($value)) {
        return $value;
    }

    return null;
}
