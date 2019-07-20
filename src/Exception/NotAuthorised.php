<?php
declare(strict_types = 1);
/**
 * @author Mehrez Labidi
 */

namespace App\Exception;

final class NotAuthorised extends \InvalidArgumentException
{
    /**
       * NotFoundResource constructor.
       * @param \Throwable $previous
       */
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct(
            "Not Authorised",
            0,
            $previous
        );
    }
}
