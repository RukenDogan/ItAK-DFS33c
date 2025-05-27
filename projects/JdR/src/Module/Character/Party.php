<?php

namespace Module\Character;

/**
 * An adventurers party, searching for conquest and glory
 */
class Party
{
    private int $currentHealthPoints;

    public function __construct(
        private readonly int $maxHealthPoints
    ) {
        $this->currentHealthPoints = $maxHealthPoints;
    }

    /**
     * tests if this Party is alive
     * @return bool
     */
    public function isAlive() : bool
    {
        return $this->currentHealthPoints > 0;
    }

    /**
     * Heal this party
     */
    public function heal() : void
    {
        $this->currentHealthPoints = min(
            $this->currentHealthPoints + 1,
            $this->maxHealthPoints
        );
    }

    /**
     * Hurt this party
     */
    public function hurt() : void
    {
        $this->currentHealthPoints = max(
            $this->currentHealthPoints - 1,
            0   // cannot be deadier than dead
        );
    }

    /**
     * Kill this Party
     */
    public function kill() : void
    {
        $this->currentHealthPoints = 0;
    }
}
