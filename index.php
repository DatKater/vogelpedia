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
        <?php
        
        require_once 'settings/object.php';
        require_once 'renderer/object.php';
        require_once '/db_access/models.php';
        
        // Tests
        $renderer = new TemplateRenderer();
        $model = new BirdModel();
        $scnd = new BreedingPlaceModel();
        echo($model->get_form());
        echo($scnd->get_form());
        echo($model->insert_query(array('idbird'=>1,'name'=>'Grünkohl')));
        echo($scnd->insert_query(array('idbreeding_place'=>1, 'name'=>'Horst')));
        
        ?>
    </body>
</html>
