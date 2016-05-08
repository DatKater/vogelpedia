<html>
<?php include 'parts/head.php' ?>
<body>
<?php include 'parts/header.php' ?>
    <fieldset>
        <legend>Vogel hinzufügen</legend>
        <form method='post'>
            <?php
                require_once('settings/object.php');
                require_once('functions.php');
                require_once('renderer/object.php');
                
                $dbHandler = get_handler(); // PDO, siehe functions.php
                $renderer = new TemplateRenderer(); // Template Renderer, siehe renderer/objects.php
                
                if(isset($_POST['debug'])) { // Wenn Debug angewaehlt
                    $debug = $_POST['debug']; // $debug ist gesetzt
                    unset($_POST['debug']); // Aus POST entfernen
                } else {
                    $debug = NULL; // Ansonsten ist Debug nicht gesetzt
                }
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Wenn POST, Formular also gesendet
                    $split_m2m = split_m2m($m2m, $_POST); // M2M Relationen von POST trennen
                    $no_m2m = $split_m2m[0]; // Daten ohne Relationen
                    $m2m_rel = $split_m2m[1]; // Nur die Relationen // Variabeln fuer Prepared-Statements, z.B. :name oder :name_latin als Array
                    
                    // Variabeln fuer Prepared-Statements, z.B. :name oder :name_latin als Array mit 
                    $bound_variables = prepare_bound_variables($no_m2m);
                    $bound = join(', ', array_keys($bound_variables)); // Prepared Statements zu String zusammenfassen, damit sie eingefuegt werden koennen
                    $columns = join(', ', array_keys($no_m2m)); // 
                    
                    echo '<pre>Bound:';
                    print_r($bound_variables);
                    echo '<br>';
                    print_r($no_m2m);
                    echo '</pre>';
                    
                    // SQL Statement mit Prepared Statements, $columns enthaelt alle Spalten, die per POST angekommen sind, $bound die prepared Statements als String
                    $query = sprintf('INSERT INTO bird (%s) VALUES (%s);', $columns, $bound);
                    
                    if(!$debug){ // Wenn Debug nicht aktiv ist, soll die Query ausgefuehrt werden
                        $stmt = $dbHandler->prepare($query); // Statement erstellen
                        $stmt->execute($bound_variables); // Statement ausfuehren, hier werden die Werte :name, :name_latin etc. durch die richtigen Werte ersetzt
                        
                        $id = $dbHandler->lastInsertId(); // Die ID des letzten Inserts erhalten (also die des Vogels, der grade hinzugefuegt wurde)
                        $stmt->closeCursor(); // Statement schliessen
                        echo '<br> ID',$id,'</br>';
                        handle_m2m($m2m_rel, $id, $dbHandler); // M2M-Relationen verarbeiten
                        
                    } else { // Wenn Debug aktiv ist, werden relevante Infos zum Debuggen ausgegeben
                        print_r($query);
                        echo '<pre>';
                        print_r($no_m2m);
                        print_r($m2m_rel);
                        print_r($_POST);
                        echo '</pre>';
                        
                    }
                } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') { // Wenn GET, also das Formular angefordert wird
                    $family_keys = get_values_from_db($dbHandler, 'family'); // family Werte abfragen (FK)
                    $breeding_place_keys = get_values_from_db($dbHandler, 'breeding_place'); // breeding_place Werte abfragen (FK)
                    
                    $color_keys = get_values_from_db($dbHandler, 'color'); // color Werte abfragen (M2M)
                    $food_keys = get_values_from_db($dbHandler, 'food'); // food Werte abfragen (M2M)
                    $habitat_keys = get_values_from_db($dbHandler, 'habitat'); // habitat Werte abfragen (M2M)
                }
                
            ?>
            
            <!-- Formular -->
            <p><label for='name'>Name:</label><input type='text' id='name' name='name'></p>
            <p><label for='name_latin'>Name in Latein:</label><input type='text' id='name_latin' name='name_latin'></p>
            <p><label for='min_livestock'>Bestand:</label><input type='number' id='min_livestock' name='min_livestock'> bis <input type='number' id='max_livestock' name='max_livestock'></p>
            <p><label for='min_length'>Länge:</label><input type='number' id='min_length' name='min_length'> bis <input type='number' id='max_length' name='max_length'></p>
            <p><label for='min_wingspread'>Flügelspannweite:</label><input type='number' id='min_wingspread' name='min_wingspread'> bis <input type='number' id='max_wingspread' name='max_wingspread'></p>
            <p><label for='min_weight'>Gewicht:</label><input type='number' id='min_weight' name='min_weight'> bis <input type='number' id='max_weight' name='max_weight'></p>
            <p><label for='life_expectancy'>Lebenserwartung:</label><input type='number' id='life_expectancy' name='life_expectancy'></p>
            <p><label for='breeding_duration'>Brutdauer:</label><input type='number' id='breeding_duration' name='breeding_duration'></p>
            <p><label for='red_list'>Rote Liste:</label><input type='checkbox' id='red_list' name='red_list'></p>
            
            <?php
                // Foreign Key Widgets rendern, also die <select> Dinger, siehe render Funktion. Erstes Argument ist die Datei, die das Template enthaelt
                // Das zweite Argument ist der Kontext, also Angaben, wodurch die Platzhalter im Template (im Array der Key) ersetzt werden sollen (im Array der entsprechende Wert)
                echo $renderer->render('widgets/foreign_key.html', array('id' => 'family',
                    'name' => 'family_idfamily', 'verbose_name' => 'Familie',
                    'array' => $family_keys, 'fk_id' => 'idfamily', 'fk_name' => 'name',
                    'multiple' => ''));
                
                echo $renderer->render('widgets/foreign_key.html', array('id' => 'breeding_place',
                    'name' => 'breeding_place_idbreeding_place', 'verbose_name' => 'Brutort',
                    'array' => $breeding_place_keys, 'fk_id' => 'idbreeding_place', 'fk_name' => 'name',
                    'multiple' => ''));
                
                // M2M Widgets rendern, <select multiple>
                echo $renderer->render('widgets/foreign_key.html', array('id' => 'bird_has_color',
                    'name' => 'bird_has_color[]', 'verbose_name' => 'Farbe',
                    'array' => $color_keys, 'fk_id' => 'idcolor', 'fk_name' => 'color_name',
                    'multiple' => 'multiple'));
                
                echo $renderer->render('widgets/foreign_key.html', array('id' => 'bird_has_food',
                    'name' => 'bird_has_food[]', 'verbose_name' => 'Nahrung',
                    'array' => $food_keys, 'fk_id' => 'idfood', 'fk_name' => 'name',
                    'multiple' => 'multiple'));
                
                echo $renderer->render('widgets/foreign_key.html', array('id' => 'bird_has_habitat',
                    'name' => 'bird_has_habitat[]', 'verbose_name' => 'Habitat',
                    'array' => $habitat_keys, 'fk_id' => 'idhabitat', 'fk_name' => 'name',
                    'multiple' => 'multiple'));
                
            ?>
            
            <p><label for='description'>Beschreibung:</label><textarea id='description' name='description'></textarea></p>
            <p><label for='debug'>Debug:</label><input type='checkbox' id='debug' name='debug'></p>
            
            <p><input type='submit' value='Absenden'><input type='reset' value='Zurücksetzen'></p>
        </form>
    </fieldset>
<?php include 'parts/footer.php' ?>
</body>
</html>
