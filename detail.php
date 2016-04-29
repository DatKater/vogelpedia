<html>
<?php include 'parts/head.php' ?>
<body>
<?php include 'parts/header.php' ?>
    
    <?php 
        require_once 'settings/object.php';
        require_once 'renderer/object.php';
        require_once '/db_access/models.php';
        require_once 'functions.php';
        
        $dbHandler = get_handler();
        $query = "SELECT * FROM bird WHERE idbird=:pk;";
        $renderer = new TemplateRenderer();
        $stmt = $dbHandler->prepare($query);
        $stmt->bindParam(':pk', $_GET['pk']);
        $stmt->execute();
        $object = $stmt->fetchAll();
        echo $renderer->render('detail_content.html', array('object' => $object[0]));
    ?>
    
<?php include 'parts/footer.php' ?>
</body>
