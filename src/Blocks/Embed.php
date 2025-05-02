<?php

declare(strict_types=1);

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Contracts\Fakeable;
use BumpCore\EditorPhp\Helpers;
use BumpCore\EditorPhp\Registry;
use Faker\Generator;
use Illuminate\Support\Facades\View;

class Embed extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'service' => [],
            'source' => [],
            'embed' => [],
            'caption' => [],
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
            'service' => 'string',
            'source' => 'url',
            'embed' => 'url',
            'width' => 'numeric',
            'height' => 'numeric',
            'caption' => 'string',
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
            return view("editor.php::{$template}.embed")
                ->with($this->only('service', 'source', 'embed', 'width', 'height', 'caption'))
                ->render();
        }

        return Helpers::renderNative(
            __DIR__ . "/../../resources/php/{$template}/embed.php",
            $this->only('service', 'source', 'embed', 'width', 'height', 'caption')
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
            'service' => $generator->text(32),
            'source' => $generator->url(),
            'embed' => $generator->url(),
            'width' => $generator->numberBetween(64, 1024),
            'height' => $generator->numberBetween(64, 1024),
            'caption' => $generator->text(32),
        ];
    }
}
