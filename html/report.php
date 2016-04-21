<!DOCTYPE html>

<html>
<?php 
    session_start(); 
    date_default_timezone_set('America/Los_Angeles');
    include '../php/dbManager.php';
?>
<head>
    <link rel="stylesheet" href="/bootstrap-3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/style/reportStyles.css"/>
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
                <td><button type="submit" name="yearReportButton" id="yearReportButton">Work Anniversary</button></td>
                <td><button type="submit" name="oneMonthFollowupButton" id="oneMonthFollowupButton">1-Month Follow Up</button></td>
                <td><button type="submit" name="threeMonthFollowupButton" id="threeMonthFollowupButton">3-Month Follow Up</button></td>
                <td><button type="submit" name="sixMonthFollowupButton" id="sixMonthFollowupButton">6-Month Follow Up</button></td>
                <td><button type="submit" name="yearFollowupButton" id="yearFollowupButton">12-Month Follow Up</button></td>
                <td><button type="submit" name="allButton" id="allButton">ALL</button></td>
            </tr>     
        </table>
    </div>
    <div id="centerDiv2">
        <label for="filterLabel" class="label" id="filterLabel">Filter</label>
        <input type="text" name="filter" id="filterInput" class="input" placeholder="Filter by keyword ..."/>
        <table id="resultsTable" class="resultsTable">
            <thead>
                <tr>
                    <th><span>Date Sourced <img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>First Name <img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Last Name <img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Employer <img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Join Date <img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Email <img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>LinkedIn <img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Notes <img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Role <img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Seniority <img src="/res/updown.png" class="arrow"/></span></th>
                    <th class='hide'><span>Gender <img src="/res/updown.png" class="arrow"/></span></th>
                    <th class='hide'><span>School <img src="/res/updown.png" class="arrow"/></span></th>
                    <th class='hide'><span>Graduation Year <img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Contacted? <img src="/res/updown.png" class="arrow"/></span></th>
                    <th class='hide'><span>Date Contacted <img src="/res/updown.png" class="arrow"/></span></th>
                    <th><span>Followed Up? <img src="/res/updown.png" class="arrow"/></span></th>
                    <th class='hide'><span>Date Followed Up <img src="/res/updown.png" class="arrow"/></span></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($_SESSION['resultArray'])) {
                        $resultArray = $_SESSION['resultArray'];
                        if(isset($resultArray)){
                            if(count($resultArray)>0){
                                for($i=0; $i<count($resultArray); $i++){
                                    echo "<tr>";
                                    foreach($resultArray[$i] as $key => $value){
                                        echo ($key == 'dateSourcedObj') ? "<td>".$value."</td>" : "";
                                        echo ($key == 'firstNameObj') ? "<td>".$value."</td>" : "";
                                        echo ($key == 'lastNameObj') ?  "<td>".$value."</td>" : "";
                                        echo ($key == 'employerNameObj') ? "<td>".$value."</td>" : "";
                                        echo ($key == 'employerDateObj') ? "<td>".$value."</td>" : "";
                                        echo ($key == 'emailObj') ? "<td>".$value."</td>" : "";
                                        echo ($key == 'linkedinObj') ? "<td>".$value."</td>" : "";
                                        echo ($key == 'notesObj') ? "<td>".$value."</td>" : "";
                                        echo ($key == 'roleObj') ? "<td>".$value."</td>" : "";
                                        echo ($key == 'seniorityObj') ? "<td>".$value."</td>" : "";
                                        echo ($key == 'genderObj') ? "<td class='hide'>".$value."</td>" : "";
                                        echo ($key == 'schoolObj') ? "<td class='hide'>".$value."</td>" : "";
                                        echo ($key == 'gradYearObj') ? "<td class='hide'>".$value."</td>" : "";
                                        echo ($key == 'contactedObj') ? "<td>".$value."</td>" : "";
                                        echo ($key == 'contactedDateObj') ? "<td class='hide'>".$value."</td>" : "";
                                        echo ($key == 'followupObj') ? "<td>".$value."</td>" : "";
                                        echo ($key == 'followupDateObj') ? "<td class='hide'>".$value."</td>" : ""; 
                                    }
                                     echo "</tr>";
                                }
                            }
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    <p></p>
    </form> 
    <div>
        <button id="exportButton">Export</button>
    </div>

</body>
</html>