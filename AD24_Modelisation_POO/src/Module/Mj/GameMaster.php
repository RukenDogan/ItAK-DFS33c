<?php

namespace Module\Mj;

use Module\Character\Party;
use Module\Scenario\Encounter;
use Module\Scenario\Outcome;
use Module\Scenario\Scenario;

/**
 * The Game master class, using various GameAccessories to give results to users.
 */
class GameMaster
{
    private array $gameAccessories;

    public function __construct(
        GameAccessory ...$gameAccessories
    ) {
        $this->gameAccessories = $gameAccessories;
    }

    protected function announce(string $message)
    {
    }

    public function pleaseGiveMeACrit() : int
    {
        // select a random game accessory
        return $this->gameAccessories[array_rand($this->gameAccessories)]
            ->generateRandomPercentScore()
        ;
    }

    public function entertainParty(Party $party, Scenario $scenario)
    {
        $encounters = $scenario->play();

        foreach ($scenario->play() as $encounter) {
            if (!$party->isAlive()) {
                break;
            }

            $this->announce(sprintf(
                "%s\n> %s",
                $encounter->title,
                $encounter->flavour,
            ));

            for ($currentTry = 0; $currentTry < Encounter::MAX_TRIES; $currentTry++) {
                $outcome = $encounter->resolve(
                    $score = $this->pleaseGiveMeACrit() + $currentTry * Encounter::EXPE_BUFF
                );

                switch ($outcome) {

                    case Outcome::FUMBLE:
                        $this->announce(sprintf("> 💀 fumble 💀 (%s)", $score));
                        $party->kill();
                        break 2;  // break switch and loop

                    case Outcome::FAILURE:
                        $this->announce(sprintf("> 🔥 failure 🔥 (%s)", $score));
                        $party->hurt();
                        break;

                    case Outcome::SUCCESS:
                        $this->announce(sprintf("> ✨ success ✨ (%s)", $score));
                        break 2;    // move to next Encounter

                    case Outcome::CRITICAL:
                        $this->announce(sprintf("> ⚡️ critical success ⚡️ (%s)", $score));
                        $party->heal();
                        break 2;
                }

                // too much failures
                if ($currentTry + 1 == Encounter::MAX_TRIES) {
                    $party->kill();
                }
            }
        }

        $this->announce($party->isAlive() ?
            '⚡️ The party wins !' :
            '💀 The party is dead !'
        );
    }
}
