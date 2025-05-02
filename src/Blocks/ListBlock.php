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

class ListBlock extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'style' => [],
            'items.*' => [],
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
            'style' => ['string', Rule::in(['ordered', 'unordered', 'checklist'])],
            'meta' => 'array',
            'items' => 'array',
            'items.*' => 'array',
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
            return view("editor.php::{$template}.list")
                ->with($this->only('style', 'items'))
                ->render();
        }

        return Helpers::renderNative(
            __DIR__ . "/../../resources/php/{$template}/list.php",
            $this->only('style', 'items')
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
        $items = [];

        foreach (range(0, $generator->numberBetween(1, 10)) as $_) {
            $items[] = [
                'content' => $generator->text(64),
            ];
        }

        return [
            'style' => $generator->randomElement(['ordered', 'unordered', 'checklist']),
            'items' => $items,
        ];
    }
}
