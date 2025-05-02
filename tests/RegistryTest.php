<?php

declare(strict_types=1);

use Hotrush\EditorPhp\Blocks\Paragraph;
use Hotrush\EditorPhp\Exceptions\InvalidBlockException;
use Hotrush\EditorPhp\Exceptions\InvalidTemplateException;
use Hotrush\EditorPhp\Registry;

test(
    'Can register block',
    function() {
        Registry::registerBlock('p', Paragraph::class);

        expect(Registry::getBlocks())->toHaveKey('p')
            ->and(Registry::getBlockByType('p'))->toEqual(Paragraph::class)
            ->and(Registry::getBlockTypeByClass(Paragraph::class))->toEqual('p');
    }
);

test(
    'Can override registered blocks',
    function() {
        Registry::registerBlocks(['p' => Paragraph::class]);
        expect(Registry::getBlocks())->toHaveKey('p');

        Registry::registerBlocks([], true);
        expect(Registry::getBlocks())->not()->toHaveKey('p');
    }
);

test(
    'Can not register invalid block',
    // @phpstan-ignore-next-line
    fn () => Registry::registerBlock('foo', get_class((new class() {})))
)->throws(InvalidBlockException::class);

test(
    'Can get fakeable blocks',
    function() {
        Registry::registerBlocks([
            'p' => Paragraph::class,
            'p2' => Paragraph::class,
            'p3' => Paragraph::class,
            'p4' => Paragraph::class,
            'p5' => Paragraph::class,
        ], true);

        expect(Registry::getFakeableBlocks())->toHaveCount(5);
    }
);

test(
    'Can check if block type exists',
    function() {
        Registry::registerBlock('p', Paragraph::class);
        expect(Registry::hasBlockType('p'))->toBeTrue()
            ->and(Registry::hasBlockType('foo'))->toBeFalse();
    }
);

test(
    'Can set template',
    function($template) {
        Registry::setTemplate($template);
        expect(Registry::getTemplate())->toEqual($template);
    }
)->with(['bootstrap-five', 'tailwind']);

test(
    'Can not set invalid template',
    fn () => Registry::setTemplate('foo')
)->throws(InvalidTemplateException::class);
