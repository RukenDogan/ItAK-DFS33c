<?php

namespace Module\Character;

use Lib\ValueObject\PositiveInt;

class Character
{
    protected $level;
    protected array $stuff = [];

    protected int $maxHealth;

    /**
     * Property hooks
     * @see https://www.php.net/manual/en/language.oop5.property-hooks.php
     */
    protected int $currentHealth = 0 {
        set => max(
            0, // cannot be deadier than dead
            min($this->maxHealth, $this->currentHealth + $value)
        );
        /* // raccourci pour
        set(int $value) {
            $this->currentHealth = max(
                0, // cannot be deadier than dead
                min($this->maxHealth, $this->currentHealth + $value)
            );
        }
        */
    }

    public int $power {
        get => max(
            0,
            array_sum([
                $this->level,
                count($this->stuff),
                -floor(($this->maxHealth - $this->currentHealth) / 2)
            ])
        );
    }

    public function __construct(
        public readonly string $name,
        PositiveInt $baseHealth,
        PositiveInt $level = new PositiveInt(1),
    ) {
        $this->maxHealth = $baseHealth->value;
        $this->currentHealth = $this->maxHealth;
        $this->level = $level->value;
    }

    public function isAlive() : bool
    {
        return $this->currentHealth > 0;
    }

    public function heal(PositiveInt $healingPower = new PositiveInt(1)) : void
    {
        $this->currentHealth = $healingPower->value;
    }

    public function hurt(PositiveInt $nbWounds = new PositiveInt(1)) : void
    {
        $this->currentHealth = -$nbWounds->value;
    }

    public function kill() : void
    {
        $this->hurt(new PositiveInt($this->maxHealth));
    }

    public function levelUp(PositiveInt $nbLevels = new PositiveInt(1)) : void
    {
        if (!$this->isAlive()) {
            throw new \LogicException('Deads cannot gain levels.');
        }

        $this->level += $nbLevels->value;
        // raccourci pour : $this->level = $this->level + $nbLevel;

        $this->maxHealth += $nbLevels->value;
        $this->heal($nbLevels);
    }

    public function loot(Equipment $equipment)
    {
        $this->stuff[] = $equipment;
    }

    public function __toString() : string
    {
        return sprintf(
            "%slv.%s %s/%s♥️  %s💪",
            str_pad($this->name, 12),
            str_pad($this->level, 2),
            str_pad($this->currentHealth, 2, ' ', STR_PAD_LEFT),
            $this->maxHealth,
            str_pad($this->power, 2, ' ', STR_PAD_LEFT)
        );
    }
}
