<?php
$SETTINGS_FILE = 'settings.ini'; // Die Settings-Datei
$settings = parse_ini_file($SETTINGS_FILE, $process_sections=true, INI_SCANNER_RAW); // Das .ini File wird gelesen, $settings kann bei Bedarf geladen werden
?>
