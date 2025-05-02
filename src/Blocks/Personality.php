<?php

declare(strict_types=1);

namespace Hotrush\EditorPhp\Blocks;

use Hotrush\EditorPhp\Block;
use Hotrush\EditorPhp\Contracts\Fakeable;
use Hotrush\EditorPhp\Helpers;
use Hotrush\EditorPhp\Registry;
use Faker\Generator;
use Illuminate\Support\Facades\View;

class Personality extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'name' => [],
            'description' => [],
            'link' => [],
            'photo' => [],
        ];
    }

    /**
     * Rules to validate data of the block.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'link' => 'url',
            'photo' => 'url',
        ];
    }

    /**
     * Renderer for the block.
     *
     * @return string
     */
    public function render(): string
    {
        $template = Registry::getTemplate();

        if (View::getFacadeRoot()) {
            return view("editor.php::{$template}.personality")
                ->with($this->only('name', 'description', 'link', 'photo'))
                ->render();
        }

        return Helpers::renderNative(
            __DIR__ . "/../../resources/php/{$template}/personality.php",
            $this->only('name', 'description', 'link', 'photo')
        );
    }

    /**
     * Generates fake data for the block.
     *
     * @param Generator $generator
     * @return array
     */
    public static function fake(Generator $generator): array
    {
        return [
            'name' => $generator->name(),
            'description' => $generator->text(),
            'link' => $generator->url(),
            'photo' => $generator->imageUrl(),
        ];
    }
}
