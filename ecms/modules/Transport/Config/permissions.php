<?php

return [
    'transport.vehicles' => [
        'index' => 'transport::vehicles.list resource',
        'create' => 'transport::vehicles.create resource',
        'edit' => 'transport::vehicles.edit resource',
        'destroy' => 'transport::vehicles.destroy resource',
    ],
    'transport.documents' => [
        'index' => 'transport::documents.list resource',
        'create' => 'transport::documents.create resource',
        'edit' => 'transport::documents.edit resource',
        'destroy' => 'transport::documents.destroy resource',
    ],
    'transport.drivers' => [
        'index' => 'transport::drivers.list resource',
        'create' => 'transport::drivers.create resource',
        'edit' => 'transport::drivers.edit resource',
        'destroy' => 'transport::drivers.destroy resource',
    ],
// append

];
