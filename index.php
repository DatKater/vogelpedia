<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Vogelpedia - Ein Vogelprojekt!</title>
        <link href="/vogelpedia/css/styles.css" rel="stylesheet">
    </head>
    <body>
        <header>
        <nav>
            <ul class="nav">
                <li><a href="/">Home</a></li>
                <li><a href="/add/">Vogel hinzufügen</a></li>
                <li><a href="/search/">Vogel suchen</a></li>
            </ul>
        </nav>
        </header>
        <h1>Vogelpedia</h1>
        <form action="" method="">
            <label for="Vogelname">Vogelname: </label><input type="text" name="Vogelname" value="" size="30" maxlength="50"> <br>
            <label for="familie">Vogelfamilie: </label><select name="familie"><option value="meisen">Meisen</option><option value="finken">Finken</option></select> <br>
            <label for="gebirge">Lebensraum: </label><select name="lebenraum"><option value="gebirge">Gebirge</option><option value="feuchtgebiete">Feuchtgebiete</option><option value="wald">Wald</option></select> <br>
            <label for="color">Farbe: </label><select name="color"><option value="gelb">Gelb</option><option value="gruen">Grün</option><option name="schwarz">Schwarz</option></select> <br>
            <label for="nahrung">Nahrung: </label><select name="nahrung"><option value="Kaefer">Käfer</option><option value="Wuermer">Würmer</option><option value="Bienen">Bienen</option></select> <br>
            <label for="Brutort">Brutort: </label><select name="Brutort"><option value="Boden">Boden</option><option value="Baumhoehle">Baumhöhle</option><option value="Busch">Busch</option></select><br>
            <input type="submit"><input type="reset">
            
        
        
        </form>
        
        <?php
        include_once '/db_access/models.php';
        
        $model = new BirdModel();
        $model->get_columns();
        
        require_once 'settings/object.php';
        print_r($settings);
        ?>
    </body>
</html>
