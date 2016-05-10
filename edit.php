<html>
<?php include 'parts/head.php' ?>
<body>
<?php
require_once('settings/object.php');
require_once('renderer/object.php');
require_once('functions.php');

is_404(!isset($_GET['pk'])); // Wenn pk nicht gesetzt ist, 404

$pk = $_GET['pk'];
$dbHandler = get_handler(); // PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = 'UPDATE bird SET %s WHERE idbird=:pk;'; // UPDATE bird SET name=:name WHERE idbird=12;
    $split_m2m = split_m2m($m2m, array_filter($_POST)); // M2M Relationen von POST trennen
    $no_m2m = $split_m2m[0]; // Daten ohne Relationen
    $m2m_rel = $split_m2m[1]; // Nur die Relationen // Variabeln fuer Prepared-Statements, z.B. :name oder :name_latin als Array

    if(isset($no_m2m['red_list'])) { // Wenn red_list ausgewaehlt wurde, wird es als red_list => on gespeichert, das wollen wir nicht
        $no_m2m['red_list'] = 1;
    } else {
        $no_m2m['red_list'] = 0;
    }

    // Variabeln fuer Prepared-Statements, z.B. :name oder :name_latin als Array mit
    $bound_variables = prepare_bound_variables($no_m2m);
    $bound = array();

    foreach($bound_variables as $key=>$val) {
        array_push($bound, substr($key, 1).'='.$key); // name=:name
    }
    $bound = join(',', $bound); // name=:name,name_latin=:name_latin etc
    $query = sprintf($query, $bound); // Query zusammenfügen
    $bound_variables[':pk'] = $pk; // pk zu den Daten hinzufuegen
    $stmt = $dbHandler->prepare($query);
    print_r($bound_variables);
    $stmt->execute($bound_variables);
    $stmt->closeCursor();
}

$query = 'SELECT * FROM bird WHERE idbird = :pk;'; // SELECT * FROM bird WHERE idbird = 12;
$stmt = $dbHandler->prepare($query);
$stmt->bindParam(':pk', $pk);
$stmt->execute();
$object = $stmt->fetchAll();
$stmt->closeCursor();

is_404(!isset($object[0])); // Wenn das Array der SQL-Abfrage leer ist, wurde kein Vogel mit der ID gefunden
$object = $object[0]; // Wenn gefunden ist er ein Level tiefer im Array

// Wenn red_list aus der DB kommt, kann es 0 oder 1 sein. Wir wollen es nur gesetzt haben, wenn es 1 ist, damit die Checkbox aktiv ist
if(isset($object['red_list'])) {
    if($object['red_list'] == 0) { // Wenn sie 0 ist, streichen wir sie einfach aus dem Array
        unset($object['red_list']);
    }
}

print_r($object);
?>
    <?php include 'parts/header.php' ?>
    <div id="main">
    <div id="inhalt">
    <br>
    <br>
    Hier k&ouml;nnen Sie einen schon bestehenden Vogel bearbeiten.
    <br><br>
    <form method="post" action="/vogelpedia/edit.php?pk=<?php echo $_GET['pk'] ?>">
    <table border="0">
    <!-- Formular -->
    <tr>
    <td><label for='name'>Name:</label></td><td><input type='text' id='name' name='name' <?php echo form_value($object, 'name', 'text'); ?>></td>
    </tr><tr>
    <td><label for='name_latin'>Name in Latein:</label></td><td><input type='text' id='name_latin' name='name_latin' <?php echo form_value($object, 'name_latin', 'text'); ?>></td>
    </tr><tr>
    <td><label for='min_livestock'>Bestand:</label></td><td><input type='number' id='min_livestock' name='min_livestock' <?php echo form_value($object, 'min_livestock', 'text'); ?>> </td><td>bis </td><td><input type='number' id='max_livestock' name='max_livestock' <?php echo form_value($object, 'max_livestock', 'text'); ?>></td>
    </tr><tr>
    <td><label for='min_length'>Länge:</label></td><td><input type='number' id='min_length' name='min_length' <?php echo form_value($object, 'min_length', 'text'); ?>></td><td> bis</td><td> <input type='number' id='max_length' name='max_length' <?php echo form_value($object, 'max_length', 'text'); ?>></td>
    </tr><tr>
    <td><label for='min_wingspread'>Flügelspannweite:</label></td><td><input type='number' id='min_wingspread' name='min_wingspread' <?php echo form_value($object, 'min_wingspread', 'text'); ?>></td><td> bis </td><td><input type='number' id='max_wingspread' name='max_wingspread' <?php echo form_value($object, 'min_wingspread', 'text'); ?>></td>
    </tr><tr>
    <td><label for='min_weight'>Gewicht:</label></td><td><input type='number' id='min_weight' name='min_weight' <?php echo form_value($object, 'min_weight', 'text'); ?>></td><td> bis </td><td><input type='text' id='max_weight' name='max_weight' <?php echo form_value($object, 'max_weight', 'text'); ?>></td>
    </tr><tr>
    <td><label for='life_expectancy'>Lebenserwartung:</label></td><td><input type='number' id='life_expectancy' name='life_expectancy' <?php echo form_value($object, 'life_expectancy', 'text'); ?>></td>
    </tr><tr>
    <td><label for='breeding_duration'>Brutdauer:</label></td><td><input type='number' id='breeding_duration' name='breeding_duration' <?php echo form_value($object, 'breeding_duration', 'text'); ?>></td>
    </tr><tr>
    <td><label for='red_list'>Rote Liste:</label></td><td><input type='checkbox' id='red_list' name='red_list' <?php echo form_value($object, 'red_list', 'checkbox'); ?>></td>
    </tr><tr>
    <td><label for='description'>Beschreibung:</label></td><td><textarea id='description' name='description'><?php echo form_value($object, 'description', 'textarea'); ?></textarea></td>
    </tr><tr><td><br></td></tr><tr>
    <td></td>
    <td><input class="button" type='submit' value='Absenden'><input class="button"type='reset' value='Zurücksetzen'></p>
    </tr>
    </table>
    </form>
    <br>
    <br>
    </div>
    </div>
<?php include 'parts/footer.php' ?>
</body>