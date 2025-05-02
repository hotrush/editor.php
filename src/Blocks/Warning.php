<?php

declare(strict_types=1);

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Contracts\Fakeable;
use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Registry;
use Faker\Generator;
use Illuminate\Support\Facades\View;

class Warning extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'title' => [],
            'message' => [],
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
            'title' => 'string',
            'message' => 'string',
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
            return view("editor.php::{$template}.warning")
                ->with($this->only('title', 'message'))
                ->render();
        }

        return Helpers::renderNative(
            __DIR__ . "/../../resources/php/{$template}/warning.php",
            $this->only('title', 'message')
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
            'title' => $generator->text(32),
            'message' => $generator->text(),
        ];
    }
}
