<?php

namespace Module\Character;

use Lib\ValueObject\PositiveInt;

class Character
{
    protected int $level;
    protected array $stuff = [];

    protected int $maxHealth;
    protected int $currentHealth = 0 {
        set => max(
            0, // cannot be deadier than dead
            min($this->maxHealth, $this->currentHealth + $value)
        );
    }

    public int $power {
        get => array_sum([
            $this->level,
            count($this->stuff),
            -floor(($this->maxHealth->value - $this->currentHealth->value) / 2)
        ]);
    }

    public function __construct(
        public readonly string $name,
        PositiveInt $baseHealth,
        ?PositiveInt $level = null
    ) {
        $this->maxHealth = $baseHealth->value;
        $this->currentHealth = $this->maxHealth;
        $this->level = $level ? $level->value : 1;
    }

    public function isAlive() : bool
    {
        return $this->currentHealth > 0;
    }

    public function heal(?PositiveInt $healingPower = null) : void
    {
        $this->currentHealth = $healingPower ? $healingPower->value : 1;
    }

    public function hurt(?PositiveInt $nbWounds = null) : void
    {
        $this->currentHealth = $nbWounds ? -$nbWounds->value : -1;
    }

    public function kill() : void
    {
        $this->hurt(new PositiveInt($this->maxHealth));
    }

    public function levelUp(?PositiveInt $nbLevels = null) : void
    {
        if (!$this->isAlive()) {
            throw new \LogicException('Deads cannot gain levels.');
        }

        $nbLevels = $nbLevels ? $nbLevels->value : 1;

        $this->level += $nbLevels;
        $this->maxHealth += $nbLevels;
        $this->heal(new PositiveInt($nbLevels));
    }

    public function loot(Equipment $equipment)
    {
        $this->stuff[] = $equipment;
    }
}
