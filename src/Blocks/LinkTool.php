<?php

declare(strict_types=1);

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Contracts\Fakeable;
use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Registry;
use Faker\Generator;
use Illuminate\Support\Facades\View;

class LinkTool extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'link' => [],
            'meta.title' => [],
            'meta.site_name' => [],
            'meta.description' => [],
            'meta.image.url' => [],
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
            'link' => 'url',
            'meta.title' => 'string',
            'meta.site_name' => 'string',
            'meta.description' => 'string',
            'meta.image.url' => 'url',
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
            return view("editor.php::{$template}.linktool")
                ->with($this->only('link', 'meta'))
                ->render();
        }

        return Helpers::renderNative(
            __DIR__ . "/../../resources/php/{$template}/linktool.php",
            $this->only('link', 'meta')
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
            'link' => $generator->url(),
            'meta' => [
                'title' => $generator->text(32),
                'site_name' => $generator->text(32),
                'description' => $generator->text(96),
                'image' => ['url' => $generator->imageUrl()],
            ],
        ];
    }
}
