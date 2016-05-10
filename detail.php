<html>
<?php include 'parts/head.php' ?>
<body>

<?php include 'parts/header.php' ?>
    
    <div id="main">
    <div id="inhalt">
        <a id="export" href="/vogelpedia/export.php?pk=<?php echo $_GET['pk'] ?>">In .csv exportieren</a>
    <a id="bearbeiten" href="/vogelpedia/edit.php?pk=<?php echo $_GET['pk'] ?>">Eintrag bearbeiten</a>
    <link href="/vogelpedia/css/styles.css" rel="stylesheet">
    <?php 
        require_once 'settings/object.php';
        require_once 'renderer/object.php';
        require_once '/db_access/models.php';
        require_once 'functions.php';
        
        $dbHandler = get_handler();
        $renderer = new TemplateRenderer();
        
//        $query = "SELECT * FROM bird WHERE idbird=:pk;";
//        $stmt = $dbHandler->prepare($query);
//        $stmt->bindParam(':pk', $_GET['pk']);
//        $stmt->execute();
//        $object = $stmt->fetchAll();
        $object = get_object_by_col($dbHandler, 'bird', 'idbird', $_GET['pk']);
        $m2m_queries = get_fk_query($params_for_m2m, ':var');
        $relations = array();
        
        foreach($m2m_queries as $name => $query) {
            $stmt = $dbHandler->prepare($query);
            $stmt->bindParam(':var', $_GET['pk']);
            $stmt->execute();
            $obj = $stmt->fetchAll();
            $relations[$name] = $obj;
        }
        
        $fks = array(
            array(
                'table' => 'breeding_place',
                'id' => 'idbreeding_place',
                'fk' => 'breeding_place_idbreeding_place'
            ),
            array(
                'table' => 'family',
                'id' => 'idfamily',
                'fk' => 'family_idfamily'
            ),
        );
        foreach($fks as $fk) {
            $obj = get_object_by_col($dbHandler, $fk['table'], $fk['id'], $object[$fk['fk']]);
            $relations[$fk['table']] = $obj;
        }
        $query = "SELECT * FROM `order` WHERE idorder=:id;";
        $stmt = $dbHandler->prepare($query);
        $stmt->bindParam(':id', $relations['family']['order_idorder']);
        $stmt->execute();
        $order = $stmt->fetchAll()[0];
        $stmt->closeCursor();
        $relations['order'] = $order;
        
        echo $renderer->render('detail_content.html', array('object' => $object, 'relations' => $relations));
    ?>
    
    </div>
    </div>
<?php include 'parts/footer.php' ?>
</body>
