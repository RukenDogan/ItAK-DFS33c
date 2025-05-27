<?php

namespace Module\Scenario;

enum Outcome : string
{
    case FUMBLE = 'fumble';
    case FAILURE = 'echec';
    case SUCCESS = 'succes';
    case CRITICAL = 'critique';
}
