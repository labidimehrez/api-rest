<?php
declare(strict_types = 1);
/**
 * @author Mehrez Labidi
 */

namespace App\Exception;

final class NotFoundEntity extends \InvalidArgumentException
{
    /**
       * NotFoundResource constructor.
       * @param \Throwable $previous
       */
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct(
            "the looked data is not found",
            0,
            $previous
        );
    }
}
