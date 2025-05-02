<?php

declare(strict_types = 1);

namespace Hotrush\EditorPhp\Casts;

use Hotrush\EditorPhp\EditorPhp;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class EditorPhpCast implements CastsAttributes
{
    /**
     * @param Model $model
     * @param string $key
     * @param string|null $value
     * @param array $attributes
     *
     * @return EditorPhp|null
     */
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if (is_null($value))
        {
            return $value;
        }

        return EditorPhp::make($value);
    }

    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     *
     * @return mixed
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof EditorPhp)
        {
            return $value->toJson();
        }

        return $value;
    }
}
