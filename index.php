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
        
        <?php
        
        require_once 'settings/object.php';
        require_once 'renderer/object.php';
        require_once '/db_access/models.php';
        require_once 'functions.php';
        
        $query = 'SELECT * FROM bird;';
        $dbHandler = get_handler();
        $objects = get_single_value_from_db($dbHandler, 'bird', 'idbird, name');
        ?>
        
        <ul>
        <?php
        foreach($objects as $object) {
            echo '<li><a href="/vogelpedia/detail.php?pk='.$object['idbird'].'">'.$object['name'].'</a></li>';
        }
        ?>
        </ul>
        
        <?php include 'parts/footer.php' ?>
    </body>
</html>
