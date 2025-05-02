<?php

namespace Hotrush\EditorPhp\Blocks;

use Hotrush\EditorPhp\Block;
use Hotrush\EditorPhp\Contracts\Fakeable;
use Hotrush\EditorPhp\Helpers;
use Hotrush\EditorPhp\Registry;
use Faker\Generator;
use Illuminate\Support\Facades\View;

class Paragraph extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'text' => [
                'a:href,target,title',
                'abbr:title',
                'b',
                'cite',
                'code',
                'em',
                'i',
                'kbd',
                'q',
                'samp',
                'small',
                'strong',
                'sub',
                'sup',
                'time:datetime',
                'var',
                'u',
                's',
                'del',
                'ins',
                'strike',
                'mark',
            ],
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
            return view("editor.php::{$template}.paragraph")
                ->with($this->only('text'))
                ->render();
        }

        return Helpers::renderNative(
            __DIR__ . "/../../resources/php/{$template}/paragraph.php",
            $this->only('text')
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
        return ['text' => $generator->text(256)];
    }
}
