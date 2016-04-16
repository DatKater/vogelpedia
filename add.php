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
                
                $dbHandler = get_handler();
                $renderer = new TemplateRenderer();
                
                if(isset($_POST['debug'])) {
                    $debug = $_POST['debug'];
                    unset($_POST['debug']);
                } else {
                    $debug = NULL;
                }
                
                $m2m = array(
                    'bird_has_color' => array(
                        'fk_id' => 'idcolor',
                        'id' => 'idbird',
                    ),
                    'bird_has_food' => array(
                        'fk_id' => 'idfood',
                        'id' => 'idbird',
                    ),
                    'bird_has_habitat' => array(
                        'fk_id' => 'idhabitat',
                        'id' => 'idbird',
                    ),
                );
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $split_m2m = split_m2m($m2m, $_POST);
                    $no_m2m = $split_m2m[0];
                    $m2m_rel = $split_m2m[1];
                    
                    $bound_variables = prepare_bound_variables($no_m2m);
                    $bound = join(', ', array_keys($bound_variables));
                    $columns = join(', ', array_keys($no_m2m));
                    
                    $query = sprintf('INSERT INTO bird (%s) VALUES (%s);', $columns, $bound);
                    
                    if(!$debug){
                        $stmt = $dbHandler->prepare($query);
                        $stmt->execute($bound_variables);
                        $stmt->closeCursor();
                        
                        $id = $dbHandler->lastInsertId();
                        echo '<br> ID',$id,'</br>';
                        handle_m2m($m2m_rel, $id, $dbHandler);
                        
                    } else {
                        print_r($query);
                        echo '<pre>';
                        print_r($no_m2m);
                        print_r($m2m_rel);
                        print_r($_POST);
                        echo '</pre>';
                        
                    }
                } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $family_keys = get_values_from_db($dbHandler, 'family');
                    $breeding_place_keys = get_values_from_db($dbHandler, 'breeding_place');
                    
                    $color_keys = get_values_from_db($dbHandler, 'color');
                    $food_keys = get_values_from_db($dbHandler, 'food');
                    $habitat_keys = get_values_from_db($dbHandler, 'habitat');
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
            
            <?php
                echo $renderer->render('widgets/foreign_key.html', array('id' => 'family',
                    'name' => 'family_idfamily', 'verbose_name' => 'Familie',
                    'array' => $family_keys, 'fk_id' => 'idfamily', 'fk_name' => 'name',
                    'multiple' => ''));
                
                echo $renderer->render('widgets/foreign_key.html', array('id' => 'breeding_place',
                    'name' => 'breeding_place_idbreeding_place', 'verbose_name' => 'Brutort',
                    'array' => $breeding_place_keys, 'fk_id' => 'idbreeding_place', 'fk_name' => 'name',
                    'multiple' => ''));
                
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
