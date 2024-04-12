<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class ContainsNumbers extends Constraint
{
    public string $message = 'The string "{{ string }}" contains an illegal character: it can only contain numbers.';
    public string $mode = 'strict';

    // all configurable options must be passed to the constructor
    public function __construct(string $mode = null, string $message = null, array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->mode = $mode ?? $this->mode;
        $this->message = $message ?? $this->message;
    }
}