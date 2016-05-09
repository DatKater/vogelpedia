<html>
<?php include 'parts/head.php' ?>
<body>
<?php include 'parts/header.php' ?>
<div id="main">
<div id="inhalt">
        <br>
        Hier k&ouml;nnen Sie mit V&ouml;gel nach bestimmten Eigenschaften filtern. F&uuml;llen sie daf&uuml;r, das untenstehende Formular aus und dr&uuml;cken Sie auf senden!
        <br>
        <br>
        <form method='get'>
            <?php

            require_once('settings/object.php');
            require_once('functions.php');
            require_once('renderer/object.php');

            $dbHandler = get_handler();
            $renderer = new TemplateRenderer();

            $query_templates = array(
                'name' => array(
                    'query' => 'name LIKE :name',
                    'bound' => '%%%s%%',
                ),
                'name_latin' => array(
                    'query' => 'name_latin LIKE :name_latin',
                    'bound' => '%%%s%%',
                ),
                'description' => array(
                    'query' => 'description LIKE :description',
                    'bound' => '%%%s%%',
                ),
                'min_livestock' => array(
                    'query' => 'min_livestock >= :min_livestock',
                    'bound' => '%s',
                ),
                'max_livestock' => array(
                    'query' => 'max_livestock <= :max_livestock',
                    'bound' => '%s',
                ),
                'min_length' => array(
                    'query' => 'min_length >= :min_length',
                    'bound' => '%s',
                ),
                'max_length' => array(
                    'query' => 'max_length <= :max_length',
                    'bound' => '%s',
                ),
                'min_wingspread' => array(
                    'query' => 'min_wingspread >= :min_wingspread',
                    'bound' => '%s',
                ),
                'max_wingspread' => array(
                    'query' => 'max_wingspread <= :max_wingspread',
                    'bound' => '%s',
                ),
                'min_weight' => array(
                    'query' => 'min_weight >= :min_weight',
                    'bound' => '%s',
                ),
                'max_weight' => array(
                    'query' => 'max_weight <= :max_weight',
                    'bound' => '%s',
                ),
                'min_life_expectancy' => array(
                    'query' => 'life_expectancy >= :min_life_expectancy',
                    'bound' => '%s',
                ),
                'max_life_expectancy' => array(
                    'query' => 'life_expectancy <= :max_life_expectancy',
                    'bound' => '%s',
                ),
                'min_breeding_duration' => array(
                    'query' => 'breeding_duration >= :min_breeding_duration',
                    'bound' => '%s',
                ),
                'max_breeding_duration' => array(
                    'query' => 'breeding_duration <= :max_breeding_duration',
                    'bound' => '%s',
                ),
                'family_idfamily' => array(
                    'query' => 'family_idfamily = :family_idfamily',
                    'bound' => '%s',
                ),
                'breeding_place_idbreeding_place' => array(
                    'query' => 'breeding_place_idbreeding_place = :breeding_place_idbreeding_place',
                    'bound' => '%s',
                ),
            );

            function prepare_query($get){
                global $query_templates;

                $new = array();
                $queries = array_intersect_key($query_templates, $get);

                foreach($queries as $key => $val) {
                    $bound = sprintf($val['bound'], $get[$key]);
                    $new[':'.$key] = $bound;
                }

                $query_strings = join(' AND ', array_map(function($el){ return $el['query']; }, $queries));
                $query = 'SELECT * FROM bird WHERE '.$query_strings.';';

                return array($query, $new);

            }

            if(!empty($_GET)) {
                $clean_get = array_filter($_GET);
                $split_m2m = split_m2m($m2m, $clean_get);
                $no_m2m = $split_m2m[0]; // Daten ohne Relationen
                $m2m_rel = $split_m2m[1]; // Nur die Relationen // Variabeln fuer Prepared-Statements, z.B. :name oder :name_latin als Array

                $query = prepare_query($clean_get);
                $bound = $query[1];
                $query = $query[0];

                $stmt = $dbHandler->prepare($query);
                $stmt->execute($bound);
                $result = $stmt->fetchAll();

                echo $query;

            }


            $family_keys = get_values_from_db($dbHandler, 'family'); // family Werte abfragen (FK)
            $breeding_place_keys = get_values_from_db($dbHandler, 'breeding_place'); // breeding_place Werte abfragen (FK)

            $color_keys = get_values_from_db($dbHandler, 'color'); // color Werte abfragen (M2M)
            $food_keys = get_values_from_db($dbHandler, 'food'); // food Werte abfragen (M2M)
            $habitat_keys = get_values_from_db($dbHandler, 'habitat'); // habitat Werte abfragen (M2M)


            ?>
            <table border="0">
            <tr>
            <td><label for='name'>Name: </label></td><td><input type='text' id='name' name='name' <?php echo form_value($_GET, 'name', 'text'); ?>></td>
            </tr><tr>
            <td><label for='name_latin'>Name in Latein: </label></td><td><input type='text' id='name_latin' name='name_latin' <?php echo form_value($_GET, 'name_latin', 'text'); ?>></td>
            </tr><tr>
            <td><label for='min_livestock'>Bestand: </label></td><td><input type='number' id='min_livestock' name='min_livestock' <?php echo form_value($_GET, 'min_livestock', 'text'); ?>></td><td>bis</td><td><input type='number' id='max_livestock' name='max_livestock' <?php echo form_value($_GET, 'max_livestock', 'text'); ?>></td>
            </tr><tr>
            <td><label for='min_length'>Länge: </label></td><td><input type='number' id='min_length' name='min_length' <?php echo form_value($_GET, 'min_length', 'text'); ?>></td><td> bis </td><td><input type='number' id='max_length' name='max_length' <?php echo form_value($_GET, 'max_length', 'text'); ?>></td>
            </tr><tr>
            <td><label for='min_wingspread'>Flügelspannweite: </label></td><td><input type='number' id='min_wingspread' name='min_wingspread' <?php echo form_value($_GET, 'min_wingspread', 'text'); ?>></td><td> bis </td><td><input type='number' id='max_wingspread' name='max_wingspread' <?php echo form_value($_GET, 'min_wingspread', 'text'); ?>></td>
            </tr><tr>
            <td><label for='min_weight'>Gewicht: </label></td><td><input type='number' id='min_weight' name='min_weight' <?php echo form_value('min_weight', 'text'); ?>></td><td> bis </td><td><input type='number' id='max_weight' name='max_weight' <?php echo form_value($_GET, 'max_weight', 'text'); ?>></td>
            </tr><tr>
            <td><label for='min_life_expectancy'>Lebenserwartung: </label></td><td><input type='number' id='min_life_expectancy' name='min_life_expectancy' <?php echo form_value($_GET, 'min_life_expectancy', 'text'); ?>></td><td> bis </td><td><input type="number" id="max_life_expectancy" name="max_life_expectancy" <?php echo form_value($_GET, 'max_life_expectancy', 'text'); ?>></td>
            </tr><tr>
            <td><label for='min_breeding_duration'>Brutdauer: </label></td><td><input type='number' id='min_breeding_duration' name='min_breeding_duration' <?php echo form_value($_GET, 'min_breeding_duration', 'text'); ?>></td><td> bis </td><td><input type="number" id="max_breeding_duration" name="max_breeding_duration" <?php echo form_value($_GET, 'max_breeding_duration', 'text'); ?>></td>
            <!--<p><label for='red_list'>Rote Liste:</label><input type='checkbox' id='red_list' name='red_list' <?php echo form_value($_GET, 'min_livestock', 'checkbox'); ?>></p>-->
            </tr>
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

           <tr>
            <td><label for='description'>Beschreibung: </label></td><td><textarea id='description' name='description'><?php echo form_value($_GET, 'description', 'textarea'); ?></textarea></td>
            </tr><tr>
            <td><br></td>
            </tr><tr>
            <td></td>
            <td><input class="button" type='submit' value='Suchen'>&nbsp;<input class="button" type='reset' value='Zurücksetzen'></td>
            </tr>
            </table>
        </form>
        <br>


    <ul>
        <?php
            if(isset($result)) {
                foreach($result as $object) {
                    echo '<li><a href="/vogelpedia/detail.php?pk='.$object['idbird'].'">'.$object['name'].'</a></li>';
                }
            }
        ?>
    </ul>
</div>
</div>
<?php include 'parts/footer.php' ?>
</body>
</html>