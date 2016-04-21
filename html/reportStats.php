<!DOCTYPE html>

<html>
<?php 
    session_start(); 
    date_default_timezone_set('America/Los_Angeles');
    include '../php/dbManager.php';
?>
<head>
    <link rel="stylesheet" href="/bootstrap-3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/style/reportStatsStyles.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="../bootstrap-3.3.6/js/bootstrap.min.js"  type="text/javascript"></script>
    <script src="../js/resultsTable.js" type="text/javascript"></script>
    <script src="../js/jquery.tablesorter.min.js" type="text/javascript"></script>
    <script src="../js/jquery.table2excel.js" type="text/javascript"></script>

    <title>Pull Reports</title>
</head>    
<body>   
    
<form action="../php/dbManager.php" method="post">
     <table class="menuTable">
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
    
     <div id="centerDiv">
        <table id="searchTable" class="searchTable">
            <tr>
               <td colspan="6"><label class="label" id="reportsLabel">Reports</label></td> 
            </tr>
            <tr height="10px"> </tr>
            <tr class="inputRow">
                <td><button type="submit" name="allStatsButton" id="allStatsButton">All Stats</button></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr> 
        </table>
    </div>
    <div id="centerDiv2">
        <label for="filterLabel" class="label">Filter</label>
        <input type="text" name="filter" id="filterInput" class="input" placeholder="Filter by keyword ..."/>
        <table id="resultsTable" class="resultsTable">
            <thead>
                <tr>
                    <th><span>Month/Year&nbsp;&nbsp;<img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Month&nbsp;&nbsp;<img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Year&nbsp;&nbsp;<img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Role&nbsp;&nbsp;<img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Source&nbsp;&nbsp;<img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Stage&nbsp;&nbsp;<img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span># Candidates&nbsp;&nbsp;<img src="/res/updown.png" class="arrow"/></span></th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                    function clearCSV(){
                        $fp = fopen('data.csv', 'w');
                        $line = "MonthYear,Month,Year,Role,Source,Stage,Candidates";
                        $val = explode(",",$line);
                        fputcsv($fp, $val);
                        fclose($fp);
                    }
                    
                    function printStats($month, $year, $role, $source, $stage, $candidates) {
                        $monthYear = $month."/".$year;
                        
                        echo "<td>".$month."/".$year."</td>";
                        echo "<td>".$month."</td>";
                        echo "<td>".$year."</td>";
                        echo "<td>".$role."</td>";
                        echo "<td>".$source."</td>";
                        echo "<td>".$stage."</td>";
                        echo "<td>".$candidates."</td>";
                        
                        $line = $monthYear.','.$month.','.$year.','.$role.','.$source.','.$stage.','.$candidates;
                        $fp = fopen('data.csv', 'a');
                        $val = explode(",",$line);
                        fputcsv($fp, $val);
                        fclose($fp);
                    }    
                    
                
                    if(isset($_SESSION['resultArray'])) {
                        $resultArray = $_SESSION['resultArray'];
                        $roleArray = ['Sales', 'Engineering', 'CSM', 'Interns'];
                        $sourceArray = ['Referral', 'Angel List', 'Career Site', 'Outreach', 'Hired', 'Gogohire', 'HireUp', 'Conferences'];
                        $stageArray = ['All Applicants', 'Phone Screen', 'Onsite', 'Final Onsite', 'Offer', 'Accept', 'Decline'];
                        if(isset($resultArray)){
                            if(count($resultArray)>0){
                                
                                clearCSV();
                                
                                for($i=0; $i<count($resultArray); $i++){

                                    $monthYear = '';
                                    $month = '';
                                    $year = '';
                                    foreach($resultArray[$i] as $key => $value){
                                        if (!is_numeric($key) AND (strlen($key)>2) ) {
                                        
                                            $role = '';
                                            $source = '';
                                            $stage = '';
                                            $candidates = 0;

                                            if ($key == 'statsMonth') {
                                                $monthYear = $monthYear.$value;
                                                $month = $value;
                                            } elseif ($key == 'statsYear') {
                                                $monthYear = $monthYear."/".$value;
                                                $year = $value;
                                            } else {
                                                echo '<tr>';
                                            }

                                            //Role
                                            if(strpos($key,'sales') !== false ) {
                                                $role = $roleArray[0];

                                                if(strpos($key,'Referral') !== false ) {
                                                    $source = $sourceArray[0];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'AngelList') !== false) {
                                                    $source = $sourceArray[1];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'CareerSite') !== false) {
                                                    $source = $sourceArray[2];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Outreach') !== false) {
                                                    $source = $sourceArray[3];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Hired') !== false) {
                                                    $source = $sourceArray[4];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Gogohire') !== false) {
                                                    $source = $sourceArray[5];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'HireUp') !== false) {
                                                    $source = $sourceArray[6];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Conferences') !== false) {
                                                    $source = $sourceArray[7];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                }

                                            } elseif (strpos($key,'eng') !== false) {
                                                $role = $roleArray[1];

                                                if(strpos($key,'Referral') !== false ) {
                                                    $source = $sourceArray[0];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'AngelList') !== false) {
                                                    $source = $sourceArray[1];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'CareerSite') !== false) {
                                                    $source = $sourceArray[2];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Outreach') !== false) {
                                                    $source = $sourceArray[3];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Hired') !== false) {
                                                    $source = $sourceArray[4];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Gogohire') !== false) {
                                                    $source = $sourceArray[5];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'HireUp') !== false) {
                                                    $source = $sourceArray[6];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Conferences') !== false) {
                                                    $source = $sourceArray[7];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                }  

                                            } elseif (strpos($key,'csm') !== false) {
                                                $role = $roleArray[2];

                                                if(strpos($key,'Referral') !== false ) {
                                                    $source = $sourceArray[0];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'AngelList') !== false) {
                                                    $source = $sourceArray[1];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'CareerSite') !== false) {
                                                    $source = $sourceArray[2];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Outreach') !== false) {
                                                    $source = $sourceArray[3];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Hired') !== false) {
                                                    $source = $sourceArray[4];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Gogohire') !== false) {
                                                    $source = $sourceArray[5];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'HireUp') !== false) {
                                                    $source = $sourceArray[6];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Conferences') !== false) {
                                                    $source = $sourceArray[7];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                }

                                            } elseif (strpos($key,'interns') !== false) {
                                                $role = $roleArray[3];

                                                if(strpos($key,'Referral') !== false ) {
                                                    $source = $sourceArray[0];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'AngelList') !== false) {
                                                    $source = $sourceArray[1];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'CareerSite') !== false) {
                                                    $source = $sourceArray[2];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Outreach') !== false) {
                                                    $source = $sourceArray[3];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Hired') !== false) {
                                                    $source = $sourceArray[4];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Gogohire') !== false) {
                                                    $source = $sourceArray[5];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'HireUp') !== false) {
                                                    $source = $sourceArray[6];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                } elseif (strpos($key,'Conferences') !== false) {
                                                    $source = $sourceArray[7];

                                                    if(strpos($key,'Candidates') !== false ) {
                                                        $stage = $stageArray[0];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Phone') !== false) {
                                                        $stage = $stageArray[1];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif ( (strpos($key,'Onsite') !== false) AND (strpos($key,'Final') === false) ) {
                                                        $stage = $stageArray[2];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Final') !== false) {
                                                        $stage = $stageArray[3];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Offer') !== false) {
                                                        $stage = $stageArray[4];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Accept') !== false) {
                                                        $stage = $stageArray[5];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    } elseif (strpos($key,'Decline') !== false) {
                                                        $stage = $stageArray[6];
                                                        $candidates = $value;

                                                        printStats($month, $year, $role, $source, $stage, $candidates);

                                                    }

                                                }

                                            } 
                                            
                                            if ( ($key != 'statsMonth') OR ($key != 'statsYear') ) {
                                                echo '</tr>';
                                            }
                                                

                                        }
                                    ////END FOREACH    
                                    }
                                    
                                }
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    </form> 
    <div>
        <button id="exportButton">Export</button>
    </div>

</body>
</html>