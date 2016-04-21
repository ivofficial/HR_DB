<!DOCTYPE html>

<html>
<?php 
    session_start(); 
    date_default_timezone_set('America/Los_Angeles');
    include '../php/dbManager.php';
?>
<head>
    <link rel="stylesheet" href="/bootstrap-3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/style/importStyles.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="../bootstrap-3.3.6/js/bootstrap.min.js"  type="text/javascript"></script>
    <script src="../js/resultsTable.js" type="text/javascript"></script>
    <script src="../js/jquery.tablesorter.min.js" type="text/javascript"></script>
    <script src="../js/jquery.table2excel.js" type="text/javascript"></script>

    <title>Bulk Import</title>
</head>    
<body>   
    
        <table>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Candidates <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a id="addLink" href="add.php">Add</a></li>
                        <li><a id="searchLink" href="search.php">Search</a></li>
                        <li><a id="reportLink" href="report.php">Reports</a></li>
                        <li><a id="importLink" href="import.php">Bulk Import</a></li>
                    </ul>
                </div>
            </td>
            <td>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Statistics <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a id="statsLink" href="stats.php">Stats</a></li>
                        <li><a id="editStatsLink" href="editStats.php">Edit Stats</a></li>
                        <li><a id="reportStatsLink" href="reportStats.php">Stats Reports</a></li>
                        <li><a id="dashboardLink" href="dashboard.php">Dashboard</a></li>
                    </ul>
                </div>
            </td>
        </table>
    <div id="leftDiv">
<!--
        <table class="menu"> <tr>
            <td><a id="homeLink" href="#">Home</a></td>
            <td><a id="addLink" href="add.php">Add</a></td>
            <td><a id="searchLink" href="search.php">Search</a></td>
            <td><a id="reportLink" href="report.php">Reports</a></td>
            <td><a id="importLink" href="import.php">Bulk Import</a></td>
            <td><a id="statsLink" href="stats.php">Stats</a></td>
            <td><a id="editStatsLink" href="editStats.php">Edit Stats</a></td>
            <td><a id="reportStatsLink" href="reportStats.php">Stats Reports</a></td>
            <td><a id="dashboardLink" href="dashboard.php">Dashboard</a></td>
        </tr></table>   
-->
    </div>
    <br/>
<form method="post" enctype="multipart/form-data">    
     <div id="centerDiv">
        <table id="searchTable" class="searchTable">
            <tr class="errorRow">
                <label class="errorLabel">
                    <script>
                        var param = window.location.href.split("id=");
                        if(param[1].toLowerCase() === "yes"){
                            document.write("Candidates successfully imported!");
                        } else {
                            document.write("Error importing candidates!");
                        }
                    </script>
                </label>
            </tr>
            <tr class="inputRow">
                <td><input type="file" name="importFile" id="importFile" class="input inputfile"/></td>
                <td><button type="submit" name="uploadButton" id="uploadButton">Upload</button></td>
        </table>
    </div>
    </form>
    
    <div id="centerDiv2">
        <form action="../php/dbManager.php" method="post">
            <table width="100%">
                <tr>
                    <td class="leftAlgn"><label id="filterLabel" class="label">Filter</label></td>
                    <td class="rigthAlgn"><label id="importLabel" class="label">Add to Database</label></td>
                </tr>
                <tr>
                    <td class="leftAlgn"><input type="text" name="filter" id="filterInput" class="input" placeholder="Filter by keyword ..."/></td>
                    <td class="rigthAlgn"><button type="submit" name="importButton" id="importButton">Import Candidates</button></td>
                </tr>
            </table>
            
            <table id="resultsTable" class="resultsTable">
                <?php
                    $colNumber = 0;
                    echo '<thead>';
                        echo '<tr>';
                            echo '<th class="hide"><span>Date Sourced  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th><span>First Name  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th><span>Last Name  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th><span>Employer  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th><span>Join Date  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th><span>Email  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th><span>LinkedIn  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th><span>Notes  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th><span>Role  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th><span>Seniority  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th class="hide"><span>Gender  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th class="hide"><span>School  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th class="hide"><span>Graduation Year  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th><span>Contacted?  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th class="hide"><span>Date Contacted  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th><span>Followed Up?  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                            echo '<th class="hide"><span>Date Followed Up  <img src="/res/updown.png" class="arrow"/></span></th>';
                            $colNumber++;
                        echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                        $uploaddir = '../uploads/';
                        $strContents = "";
                        if (isset($_FILES['importFile'])) { 
                            $uploadfile = $uploaddir . basename($_FILES['importFile']['name']);
                            //$fileContents = file_get_contents($_FILES['importFile']['tmp_name']);
                            move_uploaded_file($_FILES["importFile"]["tmp_name"], $uploadfile);
                            $strContents = "<html><body><table>\n\n";
                            $f = fopen($uploadfile, "r");
                          //  $f = fopen("Export.csv", "r");
                            while (($line = fgetcsv($f)) !== false) {
                                    $strContents = $strContents."<tr>";
                                    foreach ($line as $cell) {
                                            $strContents = $strContents."<td>" . htmlspecialchars($cell) . "</td>";
                                    }
                                    $strContents = $strContents."</tr>\n";
                            }
                            fclose($f);
                            $strContents = $strContents."\n</table></body></html>";
                        }                   
                        
                        $html = $strContents;
                
//                        $strContents = "";
//                        for ($i=0; $i<strlen($fileContents); $i++){
//                            
//                            $strContents = $strContents.$fileContents[$i];
//                            echo "<br/>Line: "$strContents;
//                        } 
//                        
//                        $subStr = substr($strContents, strpos($strContents, "<td>"));
//                        $html = "<html><body><table><tr>".$subStr;
                        $dom = new DOMDocument();
                        if (strlen($html)>0){
                            $dom->loadHTML($html);
                            
                            $cells = $dom->getElementsByTagName('td');
                            $cellValue = array();
                            foreach($cells as $c){
                                $val = $c->nodeValue;
                                array_push($cellValue, $val);
                            }
                            $arrCandidates = array();
                            $multiplier = count($cellValue) / $colNumber;
                            for($i = 0; $i<$multiplier;$i++){
                                echo '<tr>';
                                $arrCol = array();
                                for ($j=0; $j<$colNumber; $j++){
                                    echo '<td>'.$cellValue[$j+($i*$colNumber)].'</td>';
                                    array_push($arrCol, $cellValue[$j+($i*$colNumber)]);
                                }
                                echo '</tr>';
                                array_push($arrCandidates, $arrCol);
                            }
                            $_SESSION['arrCandidates'] = $arrCandidates;
                        } else {
                            
                        }
                       
                        //$dom->loadHTML($html);

                    echo '</tbody>';
                 ?>
            </table>
        </form>
    </div>
    <p></p>
    <div>
        <button id="exportButton">Export</button>
    </div>

</body>
</html>