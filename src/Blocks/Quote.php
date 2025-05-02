<?php

declare(strict_types=1);

namespace Hotrush\EditorPhp\Blocks;

use Faker\Generator;
use Hotrush\EditorPhp\Block;
use Hotrush\EditorPhp\Contracts\Fakeable;
use Hotrush\EditorPhp\Helpers;
use Hotrush\EditorPhp\Registry;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class Quote extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'text' => [],
            'caption' => [],
            'alignment' => [],
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
            'text' => 'string',
            'caption' => 'string',
            'alignment' => ['string', Rule::in(['left', 'center'])],
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
            return view("editor.php::{$template}.quote")
                ->with($this->only('text', 'caption', 'alignment'))
                ->render();
        }

        return Helpers::renderNative(
            __DIR__ . "/../../resources/php/{$template}/quote.php",
            $this->only('text', 'caption', 'alignment')
        );
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
        return [
            'text' => $generator->text(),
            'caption' => $generator->name(),
            'alignment' => $generator->randomElement(['left', 'center']),
        ];
    }
}
