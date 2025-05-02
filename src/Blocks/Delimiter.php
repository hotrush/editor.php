<?php

declare(strict_types = 1);

namespace Hotrush\EditorPhp\Blocks;

use Faker\Generator;
use Hotrush\EditorPhp\Block;
use Hotrush\EditorPhp\Contracts\Fakeable;
use Hotrush\EditorPhp\Helpers;
use Hotrush\EditorPhp\Registry;
use Illuminate\Support\Facades\View;

class Delimiter extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return '*';
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Renderer for the block.
     *
     * @return string
     */
    public function render(): string
    {
        $template = Registry::getTemplate();

        if (View::getFacadeRoot())
        {
            return view("editor.php::{$template}.delimiter")
                ->render();
        }

        return Helpers::renderNative(__DIR__ . "/../../resources/php/{$template}/delimiter.php");
    }

    /**
     * Generates fake data for the block.
     *
     * @param Generator $generator
     *
     * @return array
     */
    public static function fake(Generator $generator): array
    {
        return [];
    }
}
