<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Exception;

/**
 * Description of InvalidParametersException
 *
 * @author mehrez
 */
final class InvalidParametersException extends \InvalidArgumentException
{

    /**
     * InvalidParametersException constructor.
     * @param \Throwable $previous
     */
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct(
            "the used  parameter is invalid or not found",
            0,
            $previous
        );
    }
}
