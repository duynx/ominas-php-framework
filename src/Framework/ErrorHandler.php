<?php
declare(strict_types=1);

namespace Framework;
use ErrorException;
use Framework\Exceptions\PageNotFoundException;
use Throwable;

class ErrorHandler
{
    public static function handleError(
        int $errNo,
        string $errStr,
        string $errFile,
        int $errLine
    ): bool
    {
        throw new ErrorException($errStr, 0, $errNo, $errFile, $errLine);
    }

    public static function handleException(Throwable $exception): void
    {
        if($exception instanceof PageNotFoundException) {
            http_response_code(404);
            $template = "404.php";
        }else {
            http_response_code(500);
            $template = "500.php";
        }

        if($_ENV["SHOW_ERRORS"]) {
            ini_set('display_errors', '1');
        }else{
            ini_set('display_errors', '0');
            require dirname(__DIR__, 2) . "/views/$template";
        }
        throw $exception;
    }
}