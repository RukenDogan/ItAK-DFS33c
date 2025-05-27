<?php

namespace Module\Character;

class Character
{
    private int $currentHealth;

    public function __construct(
        private int $maxHealth
    ) {
        $currentHealth = $this->maxHealth;
    }

    public function isAlive() : bool
    {
        return $this->currentHealth > 0;
    }

    public function heal(int $amount = 1) : void
    {
        $this->currentHealth = min(
            $this->maxHealth,
            $this->currentHealth + $amount
        );
    }

    public function hurt(int $amount = 1) : void
    {
        $this->currentHealth = max(
            0,
            $this->currentHealth - $amount
        );
    }
}
