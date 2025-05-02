<?php

declare(strict_types=1);

function readSample(string $sample): string
{
    return file_get_contents(__DIR__ . "/samples/$sample.json");
}

function readSampleAndDecode(string $sample): array
{
    return [json_decode(readSample($sample), true)];
}

dataset('valid', [
    'valid' => readSample('valid'),
]);

dataset('broken', [
    'broken' => readSample('broken'),
]);

dataset('unknownType', [
    'sample' => readSample('unknownType'),
]);

dataset('unmatchingSchema', [
    'unmatchingSchema' => readSample('unmatchingSchema'),
]);

dataset('valid-array', [
    'valid' => readSampleAndDecode('valid'),
]);

dataset('unknownType-array', [
    'sample' => readSampleAndDecode('unknownType'),
]);

dataset('unmatchingSchema-array', [
    'unmatchingSchema' => readSampleAndDecode('unmatchingSchema'),
]);