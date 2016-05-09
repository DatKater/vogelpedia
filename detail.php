<html>
<?php include 'parts/head.php' ?>
<body>

<?php include 'parts/header.php' ?>
    
    <div id="main">
    <div id="inhalt">
    <a id="bearbeiten" href="/vogelpedia/edit.php?pk=<?php echo $_GET['pk'] ?>">Eintrag bearbeiten</a>
    <link href="/vogelpedia/css/styles.css" rel="stylesheet">
    <?php 
        require_once 'settings/object.php';
        require_once 'renderer/object.php';
        require_once '/db_access/models.php';
        require_once 'functions.php';
        
        $dbHandler = get_handler();
        $renderer = new TemplateRenderer();
        
        
        $query = "SELECT * FROM bird WHERE idbird=:pk;";
        $stmt = $dbHandler->prepare($query);
        $stmt->bindParam(':pk', $_GET['pk']);
        $stmt->execute();
        $object = $stmt->fetchAll();
        $m2m_queries = get_fk_query($params_for_m2m, ':var');
        $relations = array();
        
        foreach($m2m_queries as $name => $query) {
            $stmt = $dbHandler->prepare($query);
            $stmt->bindParam(':var', $_GET['pk']);
            $stmt->execute();
            $obj = $stmt->fetchAll();
            $relations[$name] = $obj;
        }
        
        echo $renderer->render('detail_content.html', array('object' => $object[0], 'relations' => $relations));
    ?>
    
    </div>
    </div>
<?php include 'parts/footer.php' ?>
</body>
