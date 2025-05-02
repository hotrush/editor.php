<?php

declare(strict_types=1);

namespace BumpCore\EditorPhp\Blocks;

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Contracts\Fakeable;
use Faker\Generator;

class Raw extends Block implements Fakeable
{
    /**
     * Sanitize rules for sanitizing data.
     *
     * @return array|string
     */
    public function sanitize(): array|string
    {
        return [
            'html' => '*',
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
            'html' => 'string',
        ];
    }

    /**
     * Renderer for the block.
     *
     * @return string
     */
    public function render(): string
    {
        return $this->get('html', '');
    }

    /**
     * Generates fake data for the block.
     *
     * @param Generator $generator
     * @return array
     */
    public static function fake(Generator $generator): array
    {
        return ['html' => $generator->randomHtml()];
    }
}
