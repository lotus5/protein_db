<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Protein Database</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1><strong><u>Protein Database Search</u></strong></h1>
    <h2>SEARCH RESULTS</h2>

<?php
    require('db.php');

    // protein info
    $protein1 = filter_input(INPUT_GET, "protein1", FILTER_SANITIZE_STRING);
    $protein2 = filter_input(INPUT_GET, "protein2", FILTER_SANITIZE_STRING);
    $pdb = filter_input(INPUT_GET, "pdb", FILTER_SANITIZE_STRING);
    $mutations = filter_input(INPUT_GET, "mutations", FILTER_SANITIZE_STRING);

    // experimental info
    $experiment = filter_input(INPUT_GET, "experiment", FILTER_SANITIZE_STRING);
    $temp1 = filter_input(INPUT_GET, "temp1", FILTER_SANITIZE_NUMBER_INT);
    $temp2 = filter_input(INPUT_GET, "temp2", FILTER_SANITIZE_NUMBER_INT);
    $ph1 = filter_input(INPUT_GET, "ph1", FILTER_SANITIZE_STRING);
    $ph2 = filter_input(INPUT_GET, "ph2", FILTER_SANITIZE_STRING);

    // thermo dyn
    $bfg1 = filter_input(INPUT_GET, "bfg1", FILTER_SANITIZE_STRING);
    $bfg2 = filter_input(INPUT_GET, "bfg2", FILTER_SANITIZE_STRING);
    $cbfg1 = filter_input(INPUT_GET, "cbfg1", FILTER_SANITIZE_STRING);
    $cbfg2 = filter_input(INPUT_GET, "cbfg2", FILTER_SANITIZE_STRING);

    // lit info
    $authors = filter_input(INPUT_GET, "authors", FILTER_SANITIZE_STRING);
    $journal = filter_input(INPUT_GET, "journal", FILTER_SANITIZE_STRING);
    $pubmed = filter_input(INPUT_GET, "pubmed", FILTER_SANITIZE_STRING);

    // checkbox processing
    $checkboxlst = array();
    if (isset($_GET['displayCheckbox'])) {
        $checkboxlst = $_GET['displayCheckbox'];
    } 

    if (!$protein1 && !$protein2 && !$pdb && !$mutations && $experiment == "All" && 
    !$temp1 && !$temp2 && !$ph1 && !$ph2 && !$bfg1 && !$bfg2 && !$cbfg1 && !$cbfg2 && !$authors && !$journal && !$pubmed) {
        echo "no input<br>";
    } else {
        if (isset($_GET['pagenum'])) {
            $pagenum = $_GET['pagenum'];
        } else {
            $pagenum = 1;
        }

        $query = 'SELECT count(*) FROM dataset WHERE ';

        $conditions = (!empty($protein1) ? "Protein1 Like '%$protein1%' AND " : "") .(!empty($protein2) ? "Protein2 Like '%$protein2%' AND " : "")
        .(!empty($pdb) ? "PDB Like '%$pdb%' AND " : "") .(!empty($mutations) ? "Mutations2 Like '%$mutations%' AND " : "")  
        .(!empty($experiment) && $experiment != "All" ? "Experiment Like '$experiment' AND " : "") 

        .(!empty($temp1) && !empty($temp2) ? "(Temperature BETWEEN $temp1 AND $temp2) AND " : (!empty($temp1) ? "Temperature >= $temp1 AND " : (!empty($temp2) ? "Temperature <= $temp2 AND " : "")))  
        .(!empty($ph1) && !empty($ph2) ? "(pH BETWEEN $ph1 AND $ph2) AND " : (!empty($ph1) ? "pH >= $ph1 AND " : (!empty($ph2) ? "pH <= $ph2 AND " : "")))  
        .(!empty($bfg1) && !empty($bfg2) ? "(BindingFreeEnergy BETWEEN $bfg1 AND $bfg2) AND " : (!empty($bfg1) ? "BindingFreeEnergy >= $bfg1 AND " : (!empty($bfg2) ? "BindingFreeEnergy <= $bfg2 AND " : "")))  
        .(!empty($cbfg1) && !empty($cbfg2) ? "(ChangeBindingFreeEnergy BETWEEN $cbfg1 AND $cbfg2) AND " : (!empty($cbfg1) ? "ChangeBindingFreeEnergy >= $cbfg1 AND " : (!empty($cbfg2) ? "ChangeBindingFreeEnergy <= $cbfg2 AND " : "")))  
        .(!empty($authors) ? "Authors Like '%$authors%' AND " : "") .(!empty($journal) ? "Journal Like '%$journal%' AND " : "") 
        .(!empty($pubmed) ? "PubMedID Like '%$pubmed%' AND " : "");

        $conditions = substr($conditions, 0, -5);
        $query .= $conditions;
        // get total amount of results 
        $statement = $db->prepare($query);
        $statement->execute();
        $countres = $statement->fetch();
        echo "$countres[0] results returned.<br>";

        if ($countres[0] > 0) {

            $rowcount = $countres[0];
            $rowsperpage = 25;
            $lastpage = ceil($rowcount/$rowsperpage);
            $lim = 'LIMIT ' .($pagenum - 1) * 25 ."," . 25; 

            $selections = "";
            $pagination = "";
            foreach ($checkboxlst as $display) {
                $selections .= $display .", ";
                $pagination .= "displayCheckbox[]=$display&";
            }
            $selections = substr($selections, 0, -2);
            if (empty($selections)) {
                $selections = "Entry";
                array_push($checkboxlst, "Entry");
            }
            $pagination = substr($pagination, 0, -1);
            $query = "SELECT $selections FROM dataset WHERE $conditions $lim";
            $statement = $db->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll();
            ?>
            <br>
            <button type="button" class="btn btn-primary" id="btnExport">Export Table</button>
            <br>
            <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
            <script>
                $(document).ready(function () {
                    $("#btnExport").click(function () {
                        let table = document.getElementsByTagName("table");
                        console.log(table);
                        debugger;
                        TableToExcel.convert(table[0], {
                            name: `proteinDBResult.xlsx`,
                            sheet: {
                                name: 'proteinDBResult'
                            }
                        });
                    });
                });
            </script>

            <table>
                <tr>
                    <?php

                    echo "<br>";
                    foreach ($checkboxlst as $box) {
                        echo "<th>$box</th>";
                    }
                    ?>
                </tr>
                <tr>
                    <?php
                        foreach ($results as $item) { 
                            foreach($checkboxlst as $box) {
                                if ($box == "Entry") {
                                    echo "<td><a href=\"search.php?entryId={$item[$box]}\">{$item[$box]}</a></td>";
                                } elseif ($box == "PDB") {
                                    echo "<td><a href=\"https://www.rcsb.org/structure/{$item[$box]}\">{$item[$box]}</a></td>";
                                } elseif ($box == "PubMedID") {
                                    echo "<td><a href=\"https://pubmed.ncbi.nlm.nih.gov/{$item[$box]}/\">{$item[$box]}</a></td>";
                                } else {
                                    echo "<td>{$item[$box]}</td>";
                                }
                            }
                            echo "</tr>";
                        }
                    ?>
            </table>
            <br>
            <?php
            if ($pagenum == 1) {
                echo " FIRST PREV ";
            } else {
                echo " <a href='{$_SERVER['PHP_SELF']}?protein1=$protein1&protein2=$protein2&pdb=$pdb&mutations=$mutations&experiment=$experiment&temp1=$temp1&temp2=$temp2&ph1=$ph1&ph2=$ph2&bfg1=$bfg1&bfg2=$bfg2&cbfg1=$cbfg1&cbfg2=$cbfg2&authors=$authors&journal=$journal&pubmed=$pubmed&$pagination&pagenum=1'>FIRST</a> ";
                $prevpage = $pagenum-1;
                echo " <a href='{$_SERVER['PHP_SELF']}?protein1=$protein1&protein2=$protein2&pdb=$pdb&mutations=$mutations&experiment=$experiment&temp1=$temp1&temp2=$temp2&ph1=$ph1&ph2=$ph2&bfg1=$bfg1&bfg2=$bfg2&cbfg1=$cbfg1&cbfg2=$cbfg2&authors=$authors&journal=$journal&pubmed=$pubmed&$pagination&pagenum=$prevpage'>PREV</a> ";
            }

            echo " ( Page $pagenum of $lastpage ) ";

            if ($pagenum == $lastpage) {
                echo " NEXT LAST ";
             } else {
                $nextpage = $pagenum+1;
                echo " <a href='{$_SERVER['PHP_SELF']}?protein1=$protein1&protein2=$protein2&pdb=$pdb&mutations=$mutations&experiment=$experiment&temp1=$temp1&temp2=$temp2&ph1=$ph1&ph2=$ph2&bfg1=$bfg1&bfg2=$bfg2&cbfg1=$cbfg1&cbfg2=$cbfg2&authors=$authors&journal=$journal&pubmed=$pubmed&$pagination&pagenum=$nextpage'>NEXT</a> ";
                echo " <a href='{$_SERVER['PHP_SELF']}?protein1=$protein1&protein2=$protein2&pdb=$pdb&mutations=$mutations&experiment=$experiment&temp1=$temp1&temp2=$temp2&ph1=$ph1&ph2=$ph2&bfg1=$bfg1&bfg2=$bfg2&cbfg1=$cbfg1&cbfg2=$cbfg2&authors=$authors&journal=$journal&pubmed=$pubmed&$pagination&pagenum=$lastpage'>LAST</a> ";
             }
             echo "<br>";
        } else { ?>
            <p>The database has no such entry</p>
        <?php }
    }
    
?>
    <br>
    <a href="search.php">Return Home</a>
</body>

</html>