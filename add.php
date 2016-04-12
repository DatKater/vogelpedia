<html>
<?php include 'parts/head.php' ?>
<body>
<?php include 'parts/header.php' ?>
    <fieldset>
        <legend>Vogel hinzufügen</legend>
        <form method='post'>
            <?php
                require_once('settings/object.php');
                function prepare_bound_variables($array) {
                    $new = array();
                    foreach($array as $key => $var) {
                        $new[':'.$key] = $var;
                    }
                    return $new;
                }
                
                function get_values_from_db($handler, $table){
                    $query = sprintf('SELECT * FROM %s;', $table);
                    $stmt = $handler->prepare($query);
                    $stmt->execute();
                    $keys = $stmt->fetchAll();
                    $stmt->closeCursor();
                    echo $query;
                    
                    return $keys;
                }
                
                $dbHandler = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8',
                     $settings['database']['database_host'], $settings['database']['database_name']),
                     $settings['database']['user'], $settings['database']['password']);
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $bound_variables = prepare_bound_variables($_POST);
                    $bound = join(', ', array_keys($bound_variables));
                    $columns = join(', ', array_keys($_POST));

                    $query = 'INSERT INTO bird (%s) VALUES (%s);';
                    $query = sprintf($query, $columns, $bound);

                    $stmt = $dbHandler->prepare($query);
                    print_r($bound_variables);
                    print_r($stmt);
                    $stmt->execute($bound_variables);
                    $stmt->closeCursor();
                } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $family_keys = get_values_from_db($dbHandler, 'family');
                    $breeding_place_keys = get_values_from_db($dbHandler, 'breeding_place');
                    
                }
                
            ?>
            <p><label for='name'>Name:</label><input type='text' id='name' name='name'></p>
            <p><label for='name_latin'>Name in Latein:</label><input type='text' id='name_latin' name='name_latin'></p>
            <p><label for='min_livestock'>Bestand:</label><input type='number' id='min_livestock' name='min_livestock'> bis <input type='number' id='max_livestock' name='max_livestock'></p>
            <p><label for='min_length'>Länge:</label><input type='number' id='min_length' name='min_length'> bis <input type='number' id='max_length' name='max_length'></p>
            <p><label for='min_wingspread'>Flügelspannweite:</label><input type='number' id='min_wingspread' name='min_wingspread'> bis <input type='number' id='max_wingspread' name='max_wingspread'></p>
            <p><label for='min_weight'>Gewicht:</label><input type='number' id='min_weight' name='min_weight'> bis <input type='number' id='max_weight' name='max_weight'></p>
            <p><label for='life_expectancy'>Lebenserwartung:</label><input type='number' id='life_expectancy' name='life_expectancy'></p>
            <p><label for='breeding_duration'>Brutdauer:</label><input type='number' id='breeding_duration' name='breeding_duration'></p>
            <p><label for='red_list'>Rote Liste:</label><input type='checkbox' id='red_list' name='red_list'></p>
            <p><label for='family'>Familie:</label><select id='family' type="number" name='family_idfamily'>
            <?php
                $options = '';
                foreach($family_keys as $key){
                    $options .= sprintf('<option value="%s">%s</option>', $key['idbird'], $key['name']);
                }
                echo $options;
            ?>
            </select></p>
            <p><label for='breeding_place'>Brutort:</label><select id='breeding_place' type="number" name='breeding_place_idbreeding_place'>
            <?php
                $options = '';
                foreach($breeding_place_keys as $key){
                    $options .= sprintf('<option value="%s">%s</option>', $key['idbreeding_place'], $key['name']);
                }
                echo $options;
            ?>
            </select></p>
            
            <p><input type='submit' value='Absenden'><input type='reset' value='Zurücksetzen'></p>
        </form>
    </fieldset>
<?php include 'parts/footer.php' ?>
</body>
</html>
