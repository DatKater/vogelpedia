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
                
                function get_select_fk(){
                    $select = "<p><label for=''>%s</label></p>";
                }
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $bound_variables = prepare_bound_variables($_POST);
                    $bound = join(', ', array_keys($bound_variables));
                    $columns = join(', ', array_keys($_POST));
                    
                    $query = 'INSERT INTO bird (%s) VALUES (%s);';
                    $query = sprintf($query, $columns, $bound);

                    $stmt = $dbHandler->prepare($query);
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
            
            <?php
//                echo $renderer->render('widgets/foreign_key.html', array('id' => 'family',
//                    'name' => 'family_idfamily', 'verbose_name' => 'Familie',
//                    'array' => $family_keys, 'fk_id' => 'idbird', 'fk_name' => 'name'));
//                print_r($family_keys);
            ?>
            
            <p><label for='family'>Familie:</label><select id='family' type="number" name='family_idfamily'>
            <?php
                echo print_select_options($family_keys, 'idbird', 'name');
            ?>
            </select></p>
            
            <p><label for='breeding_place'>Brutort:</label><select id='breeding_place' type="number" name='breeding_place_idbreeding_place'>
            <?php
                echo print_select_options($breeding_place_keys, 'idbreeding_place', 'name');
            ?>
            </select></p>
            
            <p><input type='submit' value='Absenden'><input type='reset' value='Zurücksetzen'></p>
            <?php
                echo $renderer->render('widgets/foreign_key.html', array('array' => $breeding_place_keys, 'id' => 'idbreeding_place', 'name' => 'name'));
            ?>
        </form>
    </fieldset>
<?php include 'parts/footer.php' ?>
</body>
</html>
