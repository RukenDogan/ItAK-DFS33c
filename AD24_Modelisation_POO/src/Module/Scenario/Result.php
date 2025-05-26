<?php

namespace Module\Scenario;

/**
 * An Encounter possible result
 */
class Result
{
    public function __construct(
        public readonly int $probabiliy,
        public readonly Outcome $outcome
    ) {
    }
}
