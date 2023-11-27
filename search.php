<?php

    $entryid = filter_input(INPUT_GET, "entryId", FILTER_SANITIZE_NUMBER_INT);
    $keyword = filter_input(INPUT_GET, "keyword", FILTER_SANITIZE_STRING);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Protein Database</title>
    <link rel="stylesheet" href="style.css">
    <script src="research.js"></script>
</head>

<body>
    <h1><strong><u>Protein Database Search</u></strong></h1>

    <?php if (!$entryid && !$keyword) { ?>
        <fieldset>
            <legend>
                <em><strong>Simple Search</strong></em>
            </legend>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                <label for="entryId"><strong>Entry ID:</strong></label>
                <input id="entryId" type="text" name="entryId" class="textBox" required>
                <button class="bttn">Submit</button><br><br>
            </form>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                <label for="keyword"><strong>Keyword: </strong></label>
                <input type="text" name="keyword" id="keyword" class="textBox" required>
                <button class="bttn">Submit</button><br>
            </form>

        </fieldset>
        <br>

        
        <form id="myForm" action="advancedSearch.php" method="get">
            <fieldset>
                <legend>
                    <em><strong>Advanced Search</strong></em>
                </legend>
                <fieldset>
                    <legend>
                        <strong>Protein Information</strong>
                    </legend>
                    <label for="protein1"><strong>Protein 1: </strong></label>
                    <input type="text" name="protein1" id="protein1" class="textBox">

                    <label for="protein2"><strong>Protein 2: </strong></label>
                    <input type="text" name="protein2" id="protein2" class="textBox"><br><br>

                    <label for="pdb"><strong>PDB ID: </strong></label>
                    <input type="text" name="pdb" id="pdb" class="textBox">

                    <label for="mutations"><strong>Mutations: </strong></label>
                    <input type="text" name="mutations" id="mutations" class="textBox">
                </fieldset>
                <br>
                <fieldset>
                    <legend>
                        <strong>Experimental Conditions</strong>
                    </legend>

                    <label for="experiment"><strong>Experimental Technique: </strong></label>
                    <select name="experiment" id="experiment">
                        <option value="All" selected="selected">All</option>
                        <option value="Competitive displacement">Competitive displacement</option>
                        <option value="Competition ELISA">Competition ELISA</option>
                        <option value="Competitive Binding">Competitive Binding</option>
                        <option value="Surface Plasmon Resonance">Surface Plasmon Resonance</option>
                        <option value="Fluorescence Anisotropy/Polarization">Fluorescence Anisotropy/Polarization</option>
                        <option value="Sedimentation equilibrium using analytical centrifugation or surface plasmon resonance">Sedimentation equilibrium using analytical centrifugation or surface plasmon resonance</option>
                        <option value="Isothermal Titration Microcalorimetry">Isothermal Titration Microcalorimetry</option>
                        <option value="Isothermal Titration Calorimetry">Isothermal Titration Calorimetry</option>
                        <option value="Microtiter Plate Antibody Capture Assay">Microtiter Plate Antibody Capture Assay</option>
                    </select>

                    <br><br>

                    <label for="temp1"><strong>Temperature(K) </strong></label>
                    <input class="ahw" type="text" id="temp1" name="temp1" maxlength="3"> 
                    <span>  to  </span> 
                    <input class="ahw" type="text" id="temp2" name="temp2" maxlength="3"> 

                    <br><br>

                    <label for="ph"><strong>pH </strong></label>
                    <input class="ahw" type="text" id="ph1" name="ph1"> 
                    <span>  to  </span> 
                    <input class="ahw" type="text" id="ph2" name="ph2"> 
        
                </fieldset>
                <br>
                <fieldset>
                    <legend>
                        <strong>Thermodynamic Parameter</strong>
                    </legend>
                    <label for="bfg"><strong>Binding free energy (ΔG) </strong></label>
                    <input class="ahw" type="text" id="bfg1" name="bfg1"> 
                    <span>  to  </span> 
                    <input class="ahw" type="text" id="bfg2" name="bfg2"> 

                    <br><br>

                    <label for="cbfg"><strong>Change in binding free energy (ΔΔG) </strong></label>
                    <input class="ahw" type="text" id="cbfg1" name="cbfg1"> 
                    <span>  to  </span> 
                    <input class="ahw" type="text" id="cbfg2" name="cbfg2"> 
                </fieldset>
                <br>
                <fieldset>
                    <legend>
                        <strong>Literature Information</strong>
                    </legend>

                    <label for="authors"><strong>Authors: </strong></label>
                    <input type="text" name="authors" id="authors" class="textBox">

                    <label for="journal"><strong>Journal: </strong></label>
                    <input type="text" name="journal" id="journal" class="textBox"><br><br>

                    <label for="pubmed"><strong>PubMed ID: </strong></label>
                    <input type="text" name="pubmed" id="pubmed" class="textBox">
                </fieldset>
                <br>
                <fieldset>
                    <legend>
                        <strong>Display Columns</strong>
                    </legend>

                    
                    <input type="checkbox" name="displayCheckbox[]" id="entryIdCheckbox" value="Entry" checked>
                    <label for="entryIdCheckbox">Entry ID</label>
                    
                    <input type="checkbox" name="displayCheckbox[]" id="pdbIdCheckbox" value="PDB" >
                    <label for="pdbIdCheckbox">PDB ID</label>
                    
                    <input type="checkbox" name="displayCheckbox[]" id="mutationsCheckbox" value="Mutations2" >
                    <label for="mutationsCheckbox">Mutations</label>
                    
                    <input type="checkbox" name="displayCheckbox[]" id="protein1Checkbox" value="Protein1" >
                    <label for="protein1Checkbox">Protein 1</label>
                    
                    <input type="checkbox" name="displayCheckbox[]" id="protein2Checkbox" value="Protein2" >
                    <label for="protein2Checkbox">Protein 2</label>
                    <br>
                    <input type="checkbox" name="displayCheckbox[]" id="experimentCheckbox" value="Experiment" >
                    <label for="experimentCheckbox">Experimental Technique</label>
                    
                    <input type="checkbox" name="displayCheckbox[]" id="tempCheckbox" value="Temperature" >
                    <label for="tempCheckbox">Temperature</label>
                    
                    <input type="checkbox" name="displayCheckbox[]" id="pHCheckbox" value="pH" >
                    <label for="pHCheckbox">pH</label>
                    <br>
                    <input type="checkbox" name="displayCheckbox[]" id="bfgCheckbox" value="BindingFreeEnergy" >
                    <label for="bfgCheckbox">Binding free energy (ΔG)</label>
                    
                    <input type="checkbox" name="displayCheckbox[]" id="cbfgCheckbox" value="ChangeBindingFreeEnergy" >
                    <label for="cbfgCheckbox">Change in binding free energy (ΔΔG)</label>
                    <br>
                    <input type="checkbox" name="displayCheckbox[]" id="authorsCheckbox" value="Authors" >
                    <label for="authorsCheckbox">Authors</label>
                    
                    <input type="checkbox" name="displayCheckbox[]" id="journalCheckbox" value="Journal" >
                    <label for="journalCheckbox">Journal</label>
                    
                    <input type="checkbox" name="displayCheckbox[]" id="pubmedIdCheckbox" value="PubMedID" >
                    <label for="pubmedIdCheckbox">PubMed ID</label>
                    
                </fieldset>
            </fieldset>
            <br>
            <fieldset>
                <input type="reset" class="button" value="Clear Form">
                <input type="submit" class="button" value="Submit Information">
            </fieldset>
            <br>
        </form>
    <?php } else { ?>
        <?php require("db.php"); 
        ?>
        
        <h2>SEARCH RESULTS</h2>
        <?php
            if ($entryid) { // if entry id is submitted
                $query = 'SELECT * FROM dataset
                            WHERE Entry = :entryid';
                $statement = $db->prepare($query);
                $statement->bindValue(':entryid', $entryid);
                $statement->execute();
                $results = $statement->fetch(PDO::FETCH_ASSOC); // returns array
                
                if (!empty($results)) { ?>

                    <table style="width:50%">
                        <tr>
                            <th>Entry ID</th>
                            <td><?php echo $results['Entry'];?></td>
                        </tr>
                        <tr>
                            <th>PDB</th>
                            <td><?php echo "<a href=\"https://www.rcsb.org/structure/{$results["PDB"]}\">{$results["PDB"]}</a>";?></td>
                        </tr>
                        <tr>
                            <th>Mutations</th>
                            <td><?php echo $results['Mutations2'];?></td>
                        </tr>
                        <tr>
                            <th>Protein 1</th>
                            <td><?php echo $results['Protein1'];?></td>
                        </tr>
                        <tr>
                            <th>Protein 2</th>
                            <td><?php echo $results['Protein2'];?></td>
                        </tr>
                        <tr>
                            <th>Experimental Technique</th>
                            <td><?php echo $results['Experiment'];?></td>
                        </tr>
                        <tr>
                            <th>Temperature</th>
                            <td><?php echo $results['Temperature'];?></td>
                        </tr>
                        <tr>
                            <th>pH</th>
                            <td><?php echo $results['pH'];?></td>
                        </tr>
                        <tr>
                            <th>Binding free energy (ΔG)</th>
                            <td><?php echo $results['BindingFreeEnergy'];?></td>
                        </tr>
                        <tr>
                            <th>Change in binding free energy (ΔΔG)</th>
                            <td><?php echo $results['ChangeBindingFreeEnergy'];?></td>
                        </tr>
                        <tr>
                            <th>Authors</th>
                            <td><?php echo $results['Authors'];?></td>
                        </tr>
                        <tr>
                            <th>Journal</th>
                            <td><?php echo $results['Journal'];?></td>
                        </tr>
                        <tr>
                            <th>PubMed ID</th>
                            <td><?php echo "<a href=\"https://pubmed.ncbi.nlm.nih.gov/{$results['PubMedID']}/\">{$results['PubMedID']}</a>"; ?></td>
                        </tr>
                    </table>
                <?php 
                    } else { ?>
                    <p>The database has no such entry</p>
                <?php }
            }

            if ($keyword) {
                if (isset($_GET['pagenum'])) {
                    $pagenum = $_GET['pagenum'];
                } else {
                    $pagenum = 1;
                }
                // get total amount of results 
                $query = 'SELECT count(*) FROM dataset
                            WHERE Protein1 LIKE :keyword
                            OR Protein2 LIKE :keyword
                            OR PDB LIKE :keyword
                            OR PubMedID LIKE :keyword
                            OR Experiment LIKE :keyword';
                $statement = $db->prepare($query);
                $sqlkeyword = '%';
                $sqlkeyword .= $keyword;
                $sqlkeyword .= '%';
                $statement->bindValue(':keyword', $sqlkeyword);
                $statement->execute();
                $countres = $statement->fetch();
                echo "$countres[0] results returned.<br>";

                if ($countres[0] > 0) { ?>

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
                    <br>
                    <?php
                    $rowcount = $countres[0];
                    $rowsperpage = 25;
                    $lastpage = ceil($rowcount/$rowsperpage);
                    $lim = 'LIMIT ' .($pagenum - 1) * 25 ."," . 25; 
                    
                    $query = "SELECT * FROM dataset
                                WHERE Protein1 LIKE :keyword
                                OR Protein2 LIKE :keyword
                                OR PDB LIKE :keyword
                                OR PubMedID LIKE :keyword
                                OR Experiment LIKE :keyword
                                $lim";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':keyword', $sqlkeyword);
                    $statement->execute();
                    $results = $statement->fetchAll();
                    ?>
                    <table>
                        <tr>
                            <th>Entry</th>
                            <th>PDB</th>
                            <th>Mutations2</th>
                            <th>Protein 1</th>
                            <th>Protein 2</th>
                            <th>Experiment</th>
                            <th>Temperature</th>
                            <th>pH</th>
                            <th>Binding free energy (ΔG)</th>
                            <th>Change in binding free energy (ΔΔG)</th>
                            <th>Authors</th>
                            <th>Journal</th>
                            <th>PubMed ID</th>
                        </tr>
                        <tr>
                            <?php
                            foreach ($results as $item) { ?>
                                <td><?php echo "<a href=\"search.php?entryId={$item['Entry']}\">{$item['Entry']}</a>"; ?></td>
                                <td><?php echo "<a href=\"https://www.rcsb.org/structure/{$item["PDB"]}\">{$item["PDB"]}</a>"; ?></td>
                                <td><?php echo $item['Mutations2']; ?></td>
                                <td><?php echo $item['Protein1']; ?></td>
                                <td><?php echo $item['Protein2']; ?></td>
                                <td><?php echo $item['Experiment']; ?></td>
                                <td><?php echo $item['Temperature']; ?></td>
                                <td><?php echo $item['pH']; ?></td>
                                <td><?php echo $item['BindingFreeEnergy']; ?></td>
                                <td><?php echo $item['ChangeBindingFreeEnergy']; ?></td>
                                <td><?php echo $item['Authors']; ?></td>
                                <td><?php echo $item['Journal']; ?></td>
                                <td><?php echo "<a href=\"https://pubmed.ncbi.nlm.nih.gov/{$item['PubMedID']}/\">{$item['PubMedID']}</a>"; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        
                    </table>
                    <br>
                    <?php
                    if ($pagenum == 1) {
                        echo " FIRST PREV ";
                    } else {
                        echo " <a href='{$_SERVER['PHP_SELF']}?keyword=$keyword&pagenum=1'>FIRST</a> ";
                        $prevpage = $pagenum-1;
                        echo " <a href='{$_SERVER['PHP_SELF']}?keyword=$keyword&pagenum=$prevpage'>PREV</a> ";
                    }

                    echo " ( Page $pagenum of $lastpage ) ";

                    if ($pagenum == $lastpage) {
                        echo " NEXT LAST ";
                     } else {
                        $nextpage = $pagenum+1;
                        echo " <a href='{$_SERVER['PHP_SELF']}?keyword=$keyword&pagenum=$nextpage'>NEXT</a> ";
                        echo " <a href='{$_SERVER['PHP_SELF']}?keyword=$keyword&pagenum=$lastpage'>LAST</a> ";
                     }
                     echo "<br>";
                } else { ?>
                    <p>The database has no such entry</p>
                <?php }
            }
        ?>
    <?php } ?> 
    <br>
    <a href="search.php">Return Home</a>
</body>

</html>
