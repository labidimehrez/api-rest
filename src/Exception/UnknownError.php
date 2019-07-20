<?php

declare(strict_types = 1);
/**
 * @author Mehrez Labidi
 */

namespace App\Exception;

final class UnknownError extends \InvalidArgumentException
{
    /**
     * NotFoundResource constructor.
     *
     * @param \Throwable $previous
     */
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct(
            "This is an internal  server error",
            0,
            $previous
        );
    }
}
