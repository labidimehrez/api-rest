<?php

declare(strict_types = 1);
/**
 * @author Mehrez Labidi
 */

namespace App\Exception;

final class NotFoundResource extends \InvalidArgumentException
{
    /**
     * NotFoundResource constructor.
     *
     * @param \Throwable $previous
     */
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct(
            "The folder is empty or one of its file contents is empty",
            0,
            $previous
        );
    }
}
