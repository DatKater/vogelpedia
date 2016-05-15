<?php
$SETTINGS_FILE = 'settings.ini'; // Die Settings-Datei
$settings = parse_ini_file($SETTINGS_FILE, $process_sections=true, INI_SCANNER_RAW); // Das .ini File wird gelesen, $settings kann bei Bedarf geladen werden

// Array mit allen M2M-Relationenen, wird genutzt um <select> zu Erstellen
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

// Array mit M2M-Relationen und IDs der Tabellen, wird genutzt um 
$params_for_m2m = array(
    'color' => array( // Name der Beziehung, landet im Endarray
        'table' => array( // Eigene Tabelle
            'name' => 'color', // Name de Tabelle
            'id' => 'idcolor', // PK der Tabelle
        ),
        'table_fk' => array( // fremde Tabelle (in der Praxis immer bird)
            'name' => 'bird', // Name der Tabelle
            'id' => 'idbird', // PK der Tabelle
        ),
        'table_m2m' => array( // Tabelle der Relation
            'name' => 'bird_has_color', // Name der Tabelle
            'id_t' => 'color_idcolor', // Spalte mit Fremdschluessel der eigenen Tabelle (t)
            'id_f' => 'bird_idbird', // Spalte mit Tabelle der fremden Tabelle (f)
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
