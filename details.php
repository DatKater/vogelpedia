<html>
<?php include 'parts/head.php' ?>
<body>
<?php include 'parts/header.php' ?>
    <fieldset>
        <legend>Steckbrief</legend>
        <form method='get'>
            <?php
                require_once('renderer/opject.php');
                require_once('settings/object.php');
                require_once('functions.php');
                
                $dbHandler = get_handler();
                $renderer = new TemplateRenderer();
                
                

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

