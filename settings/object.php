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
?>
