<?php

namespace Module\Character;

class Equipment
{
    public function __construct(
        public readonly string $name,
        public readonly EquipmentCategory
    ) {
    }
}
