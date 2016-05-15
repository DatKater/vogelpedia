<html>
<?php include 'parts/head.php' ?>
<body>

<?php include 'parts/header.php' ?>
    
    <div id="main">
    <div id="inhalt">
    <a class="top_link" href="/vogelpedia/export.php?pk=<?php echo $_GET['pk'] ?>">In .csv exportieren</a>
    <a class="top_link" href="/vogelpedia/edit.php?pk=<?php echo $_GET['pk'] ?>">Eintrag bearbeiten</a>
    <link href="/vogelpedia/css/styles.css" rel="stylesheet">
    <?php 
        require_once 'settings/object.php';
        require_once 'renderer/object.php';
        require_once 'functions.php';
        
        $dbHandler = get_handler(); // PDO Objekt
        $renderer = new TemplateRenderer(); // Template Renderer
        
        $object = get_object_by_col($dbHandler, 'bird', 'idbird', $_GET['pk']); // Objekt aus der DB laden, bei dem idbird=pk ist
        $m2m_queries = get_fk_query($params_for_m2m, ':var'); // SQL fuer die Abfragen der M2M Relationen generieren, ist ein Array
        $relations = array(); // Array fuer die Rueckgabe der M2M-Query unten
        
        foreach($m2m_queries as $name => $query) { // $name enthaelt den Namen fuer die Relation, $query die Query
            $stmt = $dbHandler->prepare($query); // Statement
            $stmt->bindParam(':var', $_GET['pk']); // Parameter binden
            $stmt->execute(); // ausfuehren
            $obj = $stmt->fetchAll(); // Rueckgabe
            $relations[$name] = $obj; // Rueckgabe wird unter dem Namen der Relation gespeichert
            $stmt->closeCursor();
        }
        
        $fks = array( // Array mit allen noetigen Informationen ueber die FKs
            array(
                'table' => 'breeding_place', // fremde Tabelle
                'id' => 'idbreeding_place', // PK der Tabelle
                'fk' => 'breeding_place_idbreeding_place' // Fremdschluessel
            ),
            array(
                'table' => 'family',
                'id' => 'idfamily',
                'fk' => 'family_idfamily'
            ),
        );
        foreach($fks as $fk) { // Fuer jeden FK
            // table ist der Name der Tabelle, id der PK dieser und $object[$fk['fk']] entnimmt dem Array des abgefragten Vogels den Wert der im Fremdschluessel steht
            $obj = get_object_by_col($dbHandler, $fk['table'], $fk['id'], $object[$fk['fk']]); // Erstellt eine Query z.B. SELECT * FROM family WHERE idfamily=2;
            $relations[$fk['table']] = $obj; // Speichert die Rueckgabe
        }
        
        // Ordnung des Vogels aus der DB abfragen, haengt von der Familie des Vogels ab
        $order = get_object_by_col($dbHandler, '`order`', 'idorder', $relations['family']['order_idorder']);
        $relations['order'] = $order; // speichern
        
        // Rednert den Steckbrief, der Kontext enthaelt den Vogel und ein Array mit Relationen
        echo $renderer->render('detail_content.html', array('object' => $object, 'relations' => $relations));
    ?>
    
    </div>
    </div>
<?php include 'parts/footer.php' ?>
</body>
