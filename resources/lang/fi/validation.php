<?php

return [

    'required'             => 'Pakollinen kenttä.',
    'numeric'              => 'Anna numeerinen arvo.',
    'min'                  => [
        'numeric' => 'Pitää olla vähintään :min merkkiä.',
        'string'  => 'Pitää olla vähintään :min merkkiä.',
    ],

    'start_with_sql_command' => 'Kyselyn tulee alkaa komennoilla SELECT, INSERT, UPDATE tai DELETE.',
    'even_brackets'          => 'Tulee olla parillinen määrä sulkeita.',
    'semicolon_at_end'       => 'Kyselyn tulee päättyä puolipisteeseen',
    'semicolon_max'          => 'Kyselyssä voi olla vain yksi puolipiste',

];
