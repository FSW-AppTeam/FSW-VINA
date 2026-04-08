<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Blade view compilation race condition: two concurrent requests try to rename()
        // the same compiled view temp file. Log a single line instead of a full stacktrace.
        $this->reportable(function (ErrorException $e) {
            if (str_contains($e->getMessage(), 'rename(') && str_contains($e->getMessage(), 'No such file or directory')) {
                Log::warning('Blade view compilation race condition (safe to ignore): '.$e->getMessage());

                return false;
            }
        });
    }
}
