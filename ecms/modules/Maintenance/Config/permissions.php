<?php

return [
    'maintenance.events' => [
        'index' => 'maintenance::events.list resource',
        'create' => 'maintenance::events.create resource',
        'edit' => 'maintenance::events.edit resource',
        'destroy' => 'maintenance::events.destroy resource',
    ],
    'maintenance.fueltanks' => [
        'index' => 'maintenance::fueltanks.list resource',
        'create' => 'maintenance::fueltanks.create resource',
        'edit' => 'maintenance::fueltanks.edit resource',
        'destroy' => 'maintenance::fueltanks.destroy resource',
    ],
    'maintenance.tires' => [
        'index' => 'maintenance::tires.list resource',
        'create' => 'maintenance::tires.create resource',
        'edit' => 'maintenance::tires.edit resource',
        'destroy' => 'maintenance::tires.destroy resource',
    ],
// append



];
