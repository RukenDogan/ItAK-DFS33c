<?php

$programmes = [
    ['Pedro', 'Pascal', function() {
        echo "<3\n";
    }],
    ['Anne', function() {
        echo "06.....\n";
    }]
];

foreach ($programmes as $programme) {
    $name = $programme[0];
    $maybelastname = $programme[1];
    $script = $programme[2] ?? null;

    if (!is_string($name)) {
        echo "Invalid name for programme\n";
        exit(1);
    }
    if (is_callable($maybelastname)) {
        $script = $maybelastname;
    }
    else if(!is_string($maybelastname)) {
        echo "Invalid lastname for programme\n";
        exit(3);
    }
    if (!is_callable($script)) {
        echo "Invalid script for programme\n";
        exit(2);
    }

    echo sprintf("----- running image of type %s %s  -----\n", $name, is_string($maybelastname) ? $maybelastname : '' );
    $script();
}
