<?php
$SETTINGS_FILE = 'settings.ini'; // Die Settings-Datei
$settings = parse_ini_file($SETTINGS_FILE, $process_sections=true, INI_SCANNER_RAW); // Das .ini File wird gelesen, $settings kann bei Bedarf geladen werden

// Array mit allen M2M-Relationenen
$m2m = array(
    'bird_has_color' => array( // Tabellenname der Relation dient als Key
        'fk_id' => 'color_idcolor', // Spalte des anderen Schluessels
        'id' => 'bird_idbird', // Spalte des eigenen Schluessels (bird)
    ),
    'bird_has_food' => array( // Tabellenname der Relation dient als Key
        'fk_id' => 'food_idfood', // Spalte des anderen Schluessels
        'id' => 'bird_idbird', // Spalte des eigenen Schluessels (bird)
    ),
    'bird_has_habitat' => array( // Tabellenname der Relation dient als Key
        'fk_id' => 'habitat_idhabitat', // Spalte des anderen Schluessels
        'id' => 'bird_idbird', // Spalte des eigenen Schluessels (bird)
    ),
);
    
$params_for_m2m = array(
    'color' => array(
        'table' => array(
            'name' => 'color',
            'id' => 'idcolor',
        ),
        'table_fk' => array(
            'name' => 'bird',
            'id' => 'idbird',
        ),
        'table_m2m' => array(
            'name' => 'bird_has_color',
            'id_t' => 'color_idcolor',
            'id_f' => 'bird_idbird',
        )
    ),
    'food' => array(
        'table' => array(
            'name' => 'food',
            'id' => 'idfood',
        ),
        'table_fk' => array(
            'name' => 'bird',
            'id' => 'idbird',
        ),
        'table_m2m' => array(
            'name' => 'bird_has_food',
            'id_t' => 'food_idfood',
            'id_f' => 'bird_idbird',
        )
    ),
    'habitat' => array(
        'table' => array(
            'name' => 'habitat',
            'id' => 'idhabitat',
        ),
        'table_fk' => array(
            'name' => 'bird',
            'id' => 'idbird',
        ),
        'table_m2m' => array(
            'name' => 'bird_has_habitat',
            'id_t' => 'habitat_idhabitat',
            'id_f' => 'bird_idbird',
        )
    ),
);
?>
