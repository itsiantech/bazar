<?php

return [
    'schema' => env('URL_SCHEMA', 'http'),
    'paginatePerPage' => [
        'front' => env('FRONT_PAGINATE_PER_PAGE', 40),
    ]
];
