<?php

declare(strict_types = 1);

namespace Hotrush\EditorPhp;

use Carbon\Carbon;
use DateTime;
use Hotrush\EditorPhp\Exceptions\InvalidInputException;
use Hotrush\EditorPhp\Exceptions\SchemaMismatchException;
use Hotrush\EditorPhp\Exceptions\UnknownBlockException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Parser
{
    /**
     * Converted input JSON.
     *
     * @var array
     */
    protected array $input;

    /**
     * Constructor.
     *
     * @param array $input
     *
     * @return void
     */
    public function __construct(array $input)
    {
        $this->input = $this->handleInput($input);
    }

    /**
     * Returns the time of given `Editor.js` input.
     *
     * @return Carbon
     */
    public function time(): Carbon
    {
        // return Carbon::parse(Arr::get($this->input, 'time') / 1000);
        // return Carbon::parse(new DateTime('@' . Arr::get($this->input, 'time') / 1000));
        return Carbon::createFromTimestampMs(Arr::get($this->input, 'time'));
    }

    /**
     * Returns parsed blocks of given `Editor.js` input.
     *
     * @param EditorPhp|null $root
     *
     * @return Collection
     */
    public function blocks(?EditorPhp &$root = null): Collection
    {
        $blocks = new Collection();

        foreach (Arr::get($this->input, 'blocks') as $block)
        {
            $type = Arr::get($block, 'type');

            if (!Registry::hasBlockType($type))
            {
                throw new UnknownBlockException($type);
            }

            $blocks->push(new (Registry::getBlockByType($type))(Arr::get($block, 'data'), $root));
        }

        return $blocks;
    }

    /**
     * Returns the version of given `Editor.js` input.
     *
     * @return string
     */
    public function version(): string
    {
        return Arr::get($this->input, 'version');
    }

    /**
     * Parses given `Editor.js` input JSON.
     *
     * @param array $input
     *
     * @return array
     */
    protected function handleInput(array $input): array
    {
        if (!$this->validateSchema($input))
        {
            throw new SchemaMismatchException('Given Editor.js input is not matching schema.');
        }

        return $input;
    }

    /**
     * Validates given `Editor.js` input.
     *
     * @param array $input
     *
     * @return bool
     */
    public function validateSchema(array $input): bool
    {
        $validator = Helpers::makeValidator($input, [
            'time' => ['required', 'numeric'],
            'blocks' => ['present', 'array'],
            'blocks.*' => ['present', 'array'],
            'blocks.*.type' => ['required', 'string', Rule::in(Registry::getBlocksTypes())],
            'blocks.*.data' => ['present', 'array'],
            'version' => ['required', 'string'],
        ]);

        return !$validator->fails();
    }

    public static function fromString(string $input): self
    {
        if (!Str::isJson($input))
        {
            throw new InvalidInputException('Given Editor.js input is not a valid JSON.');
        }

        $input = json_decode($input, true);

        return new static($input);
    }
}
