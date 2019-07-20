<?php

declare(strict_types = 1);
/**
 * @author Mehrez Labidi
 */


namespace App\Exception;

final class DatabaseErrorException extends \InvalidArgumentException
{
    /**
     * DatabaseErrorException constructor.
     *
     * @param \Throwable $previous
     */
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct(
            'The table doesnt exist or doesnt contain some columns',
            0,
            $previous
        );
    }
}
