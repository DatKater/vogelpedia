<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<?php include 'parts/head.php' ?>
    <body>
        <?php include 'parts/header.php' ?>
        <h1>Vogelpedia</h1>
        <pre>
        <?php
        
        require_once 'settings/object.php';
        require_once 'renderer/object.php';
        require_once '/db_access/models.php';
        
        // Tests
        $renderer = new TemplateRenderer();
        $model = new BirdModel();
        $scnd = new BreedingPlaceModel();
        echo($model->get_form(array('name' => 'Specht', 'breeding_duration' => 12)));
        echo($scnd->get_form());
        echo($model->insert_query(array('idbird'=>1,'name'=>'Grünkohl')));
        echo($scnd->insert_query(array('idbreeding_place'=>1, 'name'=>'Horst')));
        print_r($model->get_objects()[0]->get_values());
        
        ?>
        </pre>
        
        <?php include 'parts/footer.php' ?>
    </body>
</html>
