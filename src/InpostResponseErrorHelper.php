<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use GuzzleHttp\Exception\ClientException;

class InpostResponseErrorHelper
{
    const DEFAULT_MESSAGE = 'Something went wrong!';

    public static function message(ClientException $e): string
    {
        $message = null;

        $content = json_decode($e->getResponse()->getBody()->getContents());

        if (isset($content->details)) {
            $message = json_encode($content->details);
        }

        if ($message === null
            && isset($content->error)
            && isset($content->message)
        ) {
            $message = $content->error.' : '.$content->message;
        }

        $message = $message ?? self::DEFAULT_MESSAGE;

        return $message;
    }
}
