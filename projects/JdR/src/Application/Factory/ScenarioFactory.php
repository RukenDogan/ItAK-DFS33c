<?php

namespace Application\Factory;
use Application\Scenario\Encounter;
use Application\Scenario\Scenario;

class ScenarioFactory
{
    public function createScenarioFromFile(string $JsonFileReader): Scenario
    {
        $filePath = __DIR__ . "/../../data/scenarios/{$JsonFileReader}.json";
        if (!file_exists($JsonFileReader)) {
            throw new \InvalidArgumentException("Scenario file not found: {$filePath}");
        }

        $data = json_decode(file_get_contents($filePath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Error decoding JSON from file: {$filePath}");
        }

        $encounters = [];
        foreach ($data['encounters'] as $encounterData) {
            $encounters[] = new Encounter(
                $encounterData['name'],
                $encounterData['description'],
                $encounterData['result']
            );
        }

        return new Scenario($data['name'], ...$encounters);
    }
}