<?php

namespace Module\Mj;

interface RandomResultGenerator
{
    /**
     * Generate a percentage based int from a randomized source.
     *
     * @return int
     */
    public function generateRandomPercentScore() : int;
}
