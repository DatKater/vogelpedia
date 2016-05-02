<html>
<?php include 'parts/head.php' ?>
<body>
<?php
if(!isset($_GET['pk'])) {
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
    include 'parts/404.html';
    exit;
}
?>
<?php include 'parts/header.php' ?>
    <?php 
        require_once('settings/object.php');
        require_once('renderer/object.php');
        require_once('functions.php');
        
        $pk = $_GET['pk'];
        $dbHandler = get_handler();
        $query = 'SELECT * FROM bird WHERE idbird = :pk;';
        $stmt = $dbHandler->prepare($query);
        $stmt->bindParam(':pk', $pk);
        $stmt->execute();
        $object = $stmt->fetchObject();
        
        echo $object->name;
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

    
<?php include 'parts/footer.php' ?>
</body>
