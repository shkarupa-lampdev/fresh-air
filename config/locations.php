<?php

return [
    'Ua171' => [ // 1st level of loop in the set20msplits
        'name' => 'kremenchuk',
        'stations' => [ //2nd level of loop for each location
            [
                'id' => '1748',
                'is_data_split' => true,
            ],
            [
                'id' => '1753',
                'is_data_split' => true,
            ],
                /*
            [
                'id' => '1755',
                'is_data_split' => true,
            ],
            */
            [
                'id' => '1756',
                'is_data_split' => false,
            ],
            [
                'id' => 'T3950713',
                'is_data_split' => false,
                'is_vaisala' => true,
            ],
            [
                'id' => 'T3950716',
                'is_data_split' => false,
                'is_vaisala' => true,
            ],
            [
                'id' => 'V0440346',
                'is_data_split' => false,
                'is_vaisala' => true,
            ],
        ]
    ]
];
