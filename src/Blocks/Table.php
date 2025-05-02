<?php

declare(strict_types = 1);

namespace Hotrush\EditorPhp\Blocks;

use Faker\Generator;
use Hotrush\EditorPhp\Block;
use Hotrush\EditorPhp\Contracts\Fakeable;
use Hotrush\EditorPhp\Helpers;
use Hotrush\EditorPhp\Registry;
use Illuminate\Support\Facades\View;

class Table extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'content.*.*' => [],
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
            'withHeadings' => 'boolean',
            'content' => 'array',
            'content.*' => 'array',
            'content.*.*' => 'string',
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

        if (View::getFacadeRoot())
        {
            return view("editor.php::{$template}.table")
                ->with($this->only('withHeadings', 'content'))
                ->render();
        }

        return Helpers::renderNative(
            __DIR__ . "/../../resources/php/{$template}/table.php",
            $this->only('withHeadings', 'content')
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
        $content = [];
        $width = $generator->numberBetween(2, 8);

        foreach (range(0, $generator->numberBetween(1, 10)) as $_)
        {
            $row = [];

            foreach (range(0, $width) as $__)
            {
                $row[] = $generator->text(64);
            }

            $content[] = $row;
        }

        return [
            'withHeadings' => $generator->boolean(),
            'content' => $content,
        ];
    }
}
