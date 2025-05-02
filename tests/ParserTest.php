<?php

declare(strict_types = 1);

use Carbon\Carbon;
use Hotrush\EditorPhp\Exceptions\SchemaMismatchException;
use Hotrush\EditorPhp\Parser;
use Illuminate\Support\Collection;

test(
    'Can be initiated',
    fn (array $sample) => expect(new Parser($sample))->toBeInstanceOf(Parser::class),
)->with('valid-array');

test(
    'Can access time',
    fn ($sample) => expect((new Parser($sample))->time())->toBeInstanceOf(Carbon::class)
        ->equalTo(Carbon::createFromTimestampMs(1672531199000))
)->with('valid-array');

test(
    'Can access blocks',
    fn ($sample) => expect((new Parser($sample))->blocks())->toBeInstanceOf(Collection::class)
)->with('valid-array');

test(
    'Can access version',
    fn ($sample) => expect((new Parser($sample))->version())->toBeString()
)->with('valid-array');

test(
    'Can be initiated from string',
    fn ($sample) => expect(Parser::fromString($sample))->toBeInstanceOf(Parser::class),
)->with('valid');

test(
    'Throws exception on invalid input',
    fn ($sample) => (new Parser($sample))->blocks(),
)->with('unknownType-array')->throws(SchemaMismatchException::class);

test(
    'Throws exception on un matching schema',
    fn ($sample) => new Parser($sample),
)->with('unmatchingSchema-array')->throws(SchemaMismatchException::class);
