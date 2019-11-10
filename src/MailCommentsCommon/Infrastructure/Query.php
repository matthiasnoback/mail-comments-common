<?php
declare(strict_types=1);

namespace MailCommentsCommon\Infrastructure;

final class Query
{
    public static function buildFromParameters(array $parameters): string
    {
        $subjectParts = [];

        foreach ($parameters as $name => $value) {
            $subjectParts[] = $name . '=' . rawurlencode($value);
        }

        return implode('&', $subjectParts);
    }
}
