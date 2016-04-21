<!DOCTYPE html>

<html>
<head>
    <?php 
    session_start(); 
    include '../php/dbManager.php';
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap-3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/style/editStatsStyles.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="../bootstrap-3.3.6/js/bootstrap.min.js"></script>
    <script src="../js/addCandidate.js" type="text/javascript"></script>
    <title>Edit Recruiting Stats</title>
</head>

<body>
    <form action="../php/dbManager.php" method="post">
        <table class='menuTable'>
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
            <table id="addTable">
                <tr class="errorRow"><label class="errorLabel">
                    <script>
                        var linkAttr = window.location.href.split("?");
                        var param = linkAttr[1].split("&");
                        var idParam = param[0].split("=");
                        var id = idParam[1];
                        var monthParam = param[1].split("=");
                        var month = monthParam[1];
                        var yearParam = param[2].split("=");
                        var year = yearParam[1];
                        
                        if(id === "yes"){
                            document.write("Stats successfully updated!");
                        } else if (id === "invaliddate") {
                            document.write("Enter valid month and year!");
                        } else if (id === "no") {
                            document.write("");
                        } else {
                            document.write("Error adding stats!");
                        }
                    </script>
                    </label>
                </tr>
            </table>
        </div>
        <div id="controlDiv">
            <table id="controlTable">
                <tr>
                    <td>
                        <select name="statsMonth" id="statsMonth">
                            <option value="0">--- Select Month ---</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </td>
                    <td>
                        <select name="statsYear" id="statsYear">
                            <option selected value="0">--- Select Year ---</option>
                            <option value="2016">2016</option>
                            <option value="2015">2015</option>
                            <option value="2014">2014</option>
                            <option value="2013">2013</option>
                        </select>
                    </td>
                    <td>
                        <button id="editStatsButton" name="editStatsButton">Pull Stats</button>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                     <td>
                        <button id="updateStatsButton" name="updateStatsButton">Update Stats</button>
                    </td>
                </tr>
            </table> 
        </div>
        
        <script>
            if(month > 0){
                if(year > 0) {
                    $('#statsMonth option').each(function(){
                        if($(this).val() === month){
                            $(this).attr("selected","selected");
                        }
                    });

                    $('#statsYear option').each(function(){
                        if($(this).val() === year){
                            $(this).attr("selected","selected");
                        }
                    });
                }
            }
        </script>

        <div id="leftDiv2">
        </div>

    <div class="container">
          <h2 id="rolesTitle"></h2>
          <ul class="nav nav-tabs">
            <li class="active tab"><a data-toggle="tab" href="#sales">Sales</a></li>
            <li class="tab"><a data-toggle="tab" href="#eng">Engineering</a></li>
            <li class="tab"><a data-toggle="tab" href="#csm">CSM</a></li>
            <li class="tab"><a data-toggle="tab" href="#interns">Interns</a></li>
          </ul>

  
    <?php 
        if(isset($_SESSION['resultArray'])){
            $result = $_SESSION['resultArray'];
            session_unset();
        } else {
            $result = NULL;
        }
        if(isset($result)){  
            for($i = 0 ; $i<count($result); $i++) {
                foreach ($result[$i] as $key => $value) {

                    if($key == "statsMonth" AND !is_numeric($key)) {

                    }

                    if($key == "statsYear" AND !is_numeric($key)) {

                    }

                    //SALES
                    //Referral
                    if($key == "salesReferralCandidates" AND !is_numeric($key)) {

                        echo '
                        <div class="tab-content">
                        <div id="sales" class="tab-pane fade in active">
                        <table class="statsTable" id="salesStats" name="salesStats">
                            <h2>Sales</h2>
                            <thead>
                                <tr>
                                    <th class="labelTD source">Source</th>
                                    <th class="labelTD rowHeader">Candidates</th>
                                    <th class="labelTD rowHeader">Phone Screen</th>
                                    <th class="labelTD rowHeader">Onsite</th>
                                    <th class="labelTD rowHeader">Final Onsite</th>
                                    <th class="labelTD rowHeader">Offer</th>
                                    <th class="labelTD rowHeader">Accept</th>
                                    <th class="labelTD rowHeader">Decline</th>
                                </tr>
                            </thead>
                        <tbody>                    
                        ';

                        echo '<tr>
                              <td><label class="labelTD">Referral</label></td>';
                        echo '<td><input type="number" class="input" name="salesReferralCandidates" id="salesReferralCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "salesReferralPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesReferralPhone" id="salesReferralPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "salesReferralOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesReferralOnsite" id="salesReferralOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "salesReferralFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesReferralFinal" id="salesReferralFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "salesReferralOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesReferralOffer" id="salesReferralOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "salesReferralAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesReferralAccept" id="salesReferralAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "salesReferralDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesReferralDecline" id="salesReferralDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //AngelList
                    if($key == "salesAngelListCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Angel List</label></td>';
                        echo '<td><input type="number" class="input" name="salesAngelListCandidates" id="salesAngelListCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "salesAngelListPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesAngelListPhone" id="salesAngelListPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "salesAngelListOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesAngelListOnsite" id="salesAngelListOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "salesAngelListFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesAngelListFinal" id="salesAngelListFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "salesAngelListOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesAngelListOffer" id="salesAngelListOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "salesAngelListAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesAngelListAccept" id="salesAngelListAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "salesAngelListDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesAngelListDecline" id="salesAngelListDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Career Site
                    if($key == "salesCareerSiteCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Career Site</label></td>';
                        echo '<td><input type="number" class="input" name="salesCareerSiteCandidates" id="salesCareerSiteCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "salesCareerSitePhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesCareerSitePhone" id="salesCareerSitePhone" value="'.$value.'"/></td>';
                    }
                    if($key == "salesCareerSiteOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesCareerSiteOnsite" id="salesCareerSiteOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "salesCareerSiteFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesCareerSiteFinal" id="salesCareerSiteFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "salesCareerSiteOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesCareerSiteOffer" id="salesCareerSiteOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "salesCareerSiteAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesCareerSiteAccept" id="salesCareerSiteAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "salesCareerSiteDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesCareerSiteDecline" id="salesCareerSiteDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Outreach
                    if($key == "salesOutreachCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Outreach</label></td>';
                        echo '<td><input type="number" class="input" name="salesOutreachCandidates" id="salesOutreachCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "salesOutreachPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesOutreachPhone" id="salesOutreachPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "salesOutreachOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesOutreachOnsite" id="salesOutreachOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "salesOutreachFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesOutreachFinal" id="salesOutreachFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "salesOutreachOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesOutreachOffer" id="salesOutreachOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "salesOutreachAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesOutreachAccept" id="salesOutreachAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "salesOutreachDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesOutreachDecline" id="salesOutreachDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Hired
                    if($key == "salesHiredCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Hired</label></td>';
                        echo '<td><input type="number" class="input" name="salesHiredCandidates" id="salesHiredCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "salesHiredPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHiredPhone" id="salesHiredPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "salesHiredOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHiredOnsite" id="salesHiredOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "salesHiredFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHiredFinal" id="salesHiredFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "salesHiredOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHiredOffer" id="salesHiredOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "salesHiredAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHiredAccept" id="salesHiredAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "salesHiredDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHiredDecline" id="salesHiredDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Gogohire
                    if($key == "salesGogohireCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Gogohire</label></td>';
                        echo '<td><input type="number" class="input" name="salesGogohireCandidates" id="salesGogohireCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "salesGogohirePhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesGogohirePhone" id="salesGogohirePhone" value="'.$value.'"/></td>';
                    }
                    if($key == "salesGogohireOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesGogohireOnsite" id="salesGogohireOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "salesGogohireFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesGogohireFinal" id="salesGogohireFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "salesGogohireOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesGogohireOffer" id="salesGogohireOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "salesGogohireAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesGogohireAccept" id="salesGogohireAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "salesGogohireDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesGogohireDecline" id="salesGogohireDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //HireUp
                    if($key == "salesHireUpCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">HireUp</label></td>';
                        echo '<td><input type="number" class="input" name="salesHireUpCandidates" id="salesHireUpCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "salesHireUpPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHireUpPhone" id="salesHireUpPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "salesHireUpOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHireUpOnsite" id="salesHireUpOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "salesHireUpFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHireUpFinal" id="salesHireUpFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "salesHireUpOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHireUpOffer" id="salesHireUpOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "salesHireUpAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHireUpAccept" id="salesHireUpAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "salesHireUpDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesHireUpDecline" id="salesHireUpDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Conferences
                    if($key == "salesConferencesCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Conferences</label></td>';
                        echo '<td><input type="number" class="input" name="salesConferencesCandidates" id="salesConferencesCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "salesConferencesPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesConferencesPhone" id="salesConferencesPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "salesConferencesOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesConferencesOnsite" id="salesConferencesOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "salesConferencesFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesConferencesFinal" id="salesConferencesFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "salesConferencesOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesConferencesOffer" id="salesConferencesOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "salesConferencesAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesConferencesAccept" id="salesConferencesAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "salesConferencesDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="salesConferencesDecline" id="salesConferencesDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';

                        echo '
                        </tbody>
                        </table>
                        </div>
                        ';                                    
                    }

                    //Engineering
                    //Referral
                    if($key == "engReferralCandidates" AND !is_numeric($key)) {

                        echo '
                        <div id="eng" class="tab-pane fade">
                        <table class="statsTable" id="engStats" name="engStats">
                            <h2>Engineering</h2>
                            <thead>
                                <tr>
                                    <th class="labelTD source">Source</th>
                                    <th class="labelTD rowHeader">Candidates</th>
                                    <th class="labelTD rowHeader">Phone Screen</th>
                                    <th class="labelTD rowHeader">Onsite</th>
                                    <th class="labelTD rowHeader">Final Onsite</th>
                                    <th class="labelTD rowHeader">Offer</th>
                                    <th class="labelTD rowHeader">Accept</th>
                                    <th class="labelTD rowHeader">Decline</th>
                                </tr>
                            </thead>
                        <tbody>                    
                        ';

                        echo '<tr>
                              <td><label class="labelTD">Referral</label></td>';
                        echo '<td><input type="number" class="input" name="engReferralCandidates" id="engReferralCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "engReferralPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engReferralPhone" id="engReferralPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "engReferralOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engReferralOnsite" id="engReferralOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "engReferralFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engReferralFinal" id="engReferralFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "engReferralOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engReferralOffer" id="engReferralOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "engReferralAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engReferralAccept" id="engReferralAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "engReferralDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engReferralDecline" id="engReferralDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //AngelList
                    if($key == "engAngelListCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Angel List</label></td>';
                        echo '<td><input type="number" class="input" name="engAngelListCandidates" id="engAngelListCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "engAngelListPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engAngelListPhone" id="engAngelListPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "engAngelListOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engAngelListOnsite" id="engAngelListOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "engAngelListFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engAngelListFinal" id="engAngelListFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "engAngelListOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engAngelListOffer" id="engAngelListOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "engAngelListAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engAngelListAccept" id="engAngelListAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "engAngelListDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engAngelListDecline" id="engAngelListDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Career Site
                    if($key == "engCareerSiteCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Career Site</label></td>';
                        echo '<td><input type="number" class="input" name="engCareerSiteCandidates" id="engCareerSiteCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "engCareerSitePhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engCareerSitePhone" id="engCareerSitePhone" value="'.$value.'"/></td>';
                    }
                    if($key == "engCareerSiteOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engCareerSiteOnsite" id="engCareerSiteOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "engCareerSiteFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engCareerSiteFinal" id="engCareerSiteFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "engCareerSiteOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engCareerSiteOffer" id="engCareerSiteOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "engCareerSiteAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engCareerSiteAccept" id="engCareerSiteAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "engCareerSiteDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engCareerSiteDecline" id="engCareerSiteDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Outreach
                    if($key == "engOutreachCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Outreach</label></td>';
                        echo '<td><input type="number" class="input" name="engOutreachCandidates" id="engOutreachCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "engOutreachPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engOutreachPhone" id="engOutreachPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "engOutreachOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engOutreachOnsite" id="engOutreachOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "engOutreachFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engOutreachFinal" id="engOutreachFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "engOutreachOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engOutreachOffer" id="engOutreachOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "engOutreachAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engOutreachAccept" id="engOutreachAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "engOutreachDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engOutreachDecline" id="engOutreachDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Hired
                    if($key == "engHiredCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Hired</label></td>';
                        echo '<td><input type="number" class="input" name="engHiredCandidates" id="engHiredCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "engHiredPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHiredPhone" id="engHiredPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "engHiredOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHiredOnsite" id="engHiredOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "engHiredFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHiredFinal" id="engHiredFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "engHiredOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHiredOffer" id="engHiredOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "engHiredAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHiredAccept" id="engHiredAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "engHiredDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHiredDecline" id="engHiredDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Gogohire
                    if($key == "engGogohireCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Gogohire</label></td>';
                        echo '<td><input type="number" class="input" name="engGogohireCandidates" id="engGogohireCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "engGogohirePhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engGogohirePhone" id="engGogohirePhone" value="'.$value.'"/></td>';
                    }
                    if($key == "engGogohireOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engGogohireOnsite" id="engGogohireOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "engGogohireFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engGogohireFinal" id="engGogohireFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "engGogohireOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engGogohireOffer" id="engGogohireOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "engGogohireAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engGogohireAccept" id="engGogohireAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "engGogohireDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engGogohireDecline" id="engGogohireDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //HireUp
                    if($key == "engHireUpCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">HireUp</label></td>';
                        echo '<td><input type="number" class="input" name="engHireUpCandidates" id="engHireUpCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "engHireUpPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHireUpPhone" id="engHireUpPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "engHireUpOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHireUpOnsite" id="engHireUpOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "engHireUpFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHireUpFinal" id="engHireUpFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "engHireUpOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHireUpOffer" id="engHireUpOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "engHireUpAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHireUpAccept" id="engHireUpAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "engHireUpDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engHireUpDecline" id="engHireUpDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Conferences
                    if($key == "engConferencesCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Conferences</label></td>';
                        echo '<td><input type="number" class="input" name="engConferencesCandidates" id="engConferencesCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "engConferencesPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engConferencesPhone" id="engConferencesPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "engConferencesOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engConferencesOnsite" id="engConferencesOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "engConferencesFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engConferencesFinal" id="engConferencesFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "engConferencesOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engConferencesOffer" id="engConferencesOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "engConferencesAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engConferencesAccept" id="engConferencesAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "engConferencesDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="engConferencesDecline" id="engConferencesDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';

                        echo '
                        </tbody>
                        </table>
                        </div>
                        ';                                    
                    }

                    //CSM
                    //Referral
                    if($key == "csmReferralCandidates" AND !is_numeric($key)) {

                        echo '
                        <div id="csm" class="tab-pane fade">
                        <table class="statsTable" id="csmStats" name="csmStats">
                            <h2>CSM</h2>
                            <thead>
                                <tr>
                                    <th class="labelTD source">Source</th>
                                    <th class="labelTD rowHeader">Candidates</th>
                                    <th class="labelTD rowHeader">Phone Screen</th>
                                    <th class="labelTD rowHeader">Onsite</th>
                                    <th class="labelTD rowHeader">Final Onsite</th>
                                    <th class="labelTD rowHeader">Offer</th>
                                    <th class="labelTD rowHeader">Accept</th>
                                    <th class="labelTD rowHeader">Decline</th>
                                </tr>
                            </thead>
                        <tbody>                    
                        ';

                        echo '<tr>
                              <td><label class="labelTD">Referral</label></td>';
                        echo '<td><input type="number" class="input" name="csmReferralCandidates" id="csmReferralCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "csmReferralPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmReferralPhone" id="csmReferralPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "csmReferralOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmReferralOnsite" id="csmReferralOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "csmReferralFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmReferralFinal" id="csmReferralFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "csmReferralOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmReferralOffer" id="csmReferralOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "csmReferralAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmReferralAccept" id="csmReferralAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "csmReferralDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmReferralDecline" id="csmReferralDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //AngelList
                    if($key == "csmAngelListCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Angel List</label></td>';
                        echo '<td><input type="number" class="input" name="csmAngelListCandidates" id="csmAngelListCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "csmAngelListPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmAngelListPhone" id="csmAngelListPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "csmAngelListOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmAngelListOnsite" id="csmAngelListOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "csmAngelListFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmAngelListFinal" id="csmAngelListFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "csmAngelListOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmAngelListOffer" id="csmAngelListOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "csmAngelListAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmAngelListAccept" id="csmAngelListAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "csmAngelListDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmAngelListDecline" id="csmAngelListDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }


                    //Career Site
                    if($key == "csmCareerSiteCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Career Site</label></td>';
                        echo '<td><input type="number" class="input" name="csmCareerSiteCandidates" id="csmCareerSiteCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "csmCareerSitePhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmCareerSitePhone" id="csmCareerSitePhone" value="'.$value.'"/></td>';
                    }
                    if($key == "csmCareerSiteOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmCareerSiteOnsite" id="csmCareerSiteOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "csmCareerSiteFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmCareerSiteFinal" id="csmCareerSiteFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "csmCareerSiteOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmCareerSiteOffer" id="csmCareerSiteOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "csmCareerSiteAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmCareerSiteAccept" id="csmCareerSiteAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "csmCareerSiteDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmCareerSiteDecline" id="csmCareerSiteDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Outreach
                    if($key == "csmOutreachCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Outreach</label></td>';
                        echo '<td><input type="number" class="input" name="csmOutreachCandidates" id="csmOutreachCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "csmOutreachPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmOutreachPhone" id="csmOutreachPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "csmOutreachOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmOutreachOnsite" id="csmOutreachOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "csmOutreachFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmOutreachFinal" id="csmOutreachFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "csmOutreachOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmOutreachOffer" id="csmOutreachOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "csmOutreachAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmOutreachAccept" id="csmOutreachAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "csmOutreachDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmOutreachDecline" id="csmOutreachDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Hired
                    if($key == "csmHiredCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Hired</label></td>';
                        echo '<td><input type="number" class="input" name="csmHiredCandidates" id="csmHiredCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "csmHiredPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHiredPhone" id="csmHiredPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "csmHiredOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHiredOnsite" id="csmHiredOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "csmHiredFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHiredFinal" id="csmHiredFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "csmHiredOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHiredOffer" id="csmHiredOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "csmHiredAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHiredAccept" id="csmHiredAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "csmHiredDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHiredDecline" id="csmHiredDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Gogohire
                    if($key == "csmGogohireCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Gogohire</label></td>';
                        echo '<td><input type="number" class="input" name="csmGogohireCandidates" id="csmGogohireCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "csmGogohirePhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmGogohirePhone" id="csmGogohirePhone" value="'.$value.'"/></td>';
                    }
                    if($key == "csmGogohireOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmGogohireOnsite" id="csmGogohireOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "csmGogohireFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmGogohireFinal" id="csmGogohireFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "csmGogohireOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmGogohireOffer" id="csmGogohireOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "csmGogohireAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmGogohireAccept" id="csmGogohireAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "csmGogohireDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmGogohireDecline" id="csmGogohireDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //HireUp
                    if($key == "csmHireUpCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">HireUp</label></td>';
                        echo '<td><input type="number" class="input" name="csmHireUpCandidates" id="csmHireUpCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "csmHireUpPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHireUpPhone" id="csmHireUpPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "csmHireUpOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHireUpOnsite" id="csmHireUpOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "csmHireUpFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHireUpFinal" id="csmHireUpFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "csmHireUpOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHireUpOffer" id="csmHireUpOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "csmHireUpAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHireUpAccept" id="csmHireUpAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "csmHireUpDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmHireUpDecline" id="csmHireUpDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Conferences
                    if($key == "csmConferencesCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Conferences</label></td>';
                        echo '<td><input type="number" class="input" name="csmConferencesCandidates" id="csmConferencesCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "csmConferencesPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmConferencesPhone" id="csmConferencesPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "csmConferencesOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmConferencesOnsite" id="csmConferencesOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "csmConferencesFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmConferencesFinal" id="csmConferencesFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "csmConferencesOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmConferencesOffer" id="csmConferencesOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "csmConferencesAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmConferencesAccept" id="csmConferencesAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "csmConferencesDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="csmConferencesDecline" id="csmConferencesDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';

                        echo '
                        </tbody>
                        </table>
                        </div>
                        ';                                    
                    }

                    //Interns
                    //Referral
                    if($key == "internsReferralCandidates" AND !is_numeric($key)) {

                        echo '
                        <div id="interns" class="tab-pane fade">
                        <table class="statsTable" id="internsStats" name="internsStats">
                            <h2>Interns</h2>
                            <thead>
                                <tr>
                                    <th class="labelTD source">Source</th>
                                    <th class="labelTD rowHeader">Candidates</th>
                                    <th class="labelTD rowHeader">Phone Screen</th>
                                    <th class="labelTD rowHeader">Onsite</th>
                                    <th class="labelTD rowHeader">Final Onsite</th>
                                    <th class="labelTD rowHeader">Offer</th>
                                    <th class="labelTD rowHeader">Accept</th>
                                    <th class="labelTD rowHeader">Decline</th>
                                </tr>
                            </thead>
                        <tbody>                    
                        ';

                        echo '<tr>
                              <td><label class="labelTD">Referral</label></td>';
                        echo '<td><input type="number" class="input" name="internsReferralCandidates" id="internsReferralCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "internsReferralPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsReferralPhone" id="internsReferralPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "internsReferralOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsReferralOnsite" id="internsReferralOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "internsReferralFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsReferralFinal" id="internsReferralFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "internsReferralOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsReferralOffer" id="internsReferralOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "internsReferralAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsReferralAccept" id="internsReferralAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "internsReferralDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsReferralDecline" id="internsReferralDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //AngelList
                    if($key == "internsAngelListCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Angel List</label></td>';
                        echo '<td><input type="number" class="input" name="internsAngelListCandidates" id="internsAngelListCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "internsAngelListPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsAngelListPhone" id="internsAngelListPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "internsAngelListOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsAngelListOnsite" id="internsAngelListOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "internsAngelListFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsAngelListFinal" id="internsAngelListFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "internsAngelListOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsAngelListOffer" id="internsAngelListOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "internsAngelListAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsAngelListAccept" id="internsAngelListAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "internsAngelListDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsAngelListDecline" id="internsAngelListDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Career Site
                    if($key == "internsCareerSiteCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Career Site</label></td>';
                        echo '<td><input type="number" class="input" name="internsCareerSiteCandidates" id="internsCareerSiteCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "internsCareerSitePhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsCareerSitePhone" id="internsCareerSitePhone" value="'.$value.'"/></td>';
                    }
                    if($key == "internsCareerSiteOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsCareerSiteOnsite" id="internsCareerSiteOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "internsCareerSiteFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsCareerSiteFinal" id="internsCareerSiteFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "internsCareerSiteOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsCareerSiteOffer" id="internsCareerSiteOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "internsCareerSiteAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsCareerSiteAccept" id="internsCareerSiteAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "internsCareerSiteDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsCareerSiteDecline" id="internsCareerSiteDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Outreach
                    if($key == "internsOutreachCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Outreach</label></td>';
                        echo '<td><input type="number" class="input" name="internsOutreachCandidates" id="internsOutreachCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "internsOutreachPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsOutreachPhone" id="internsOutreachPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "internsOutreachOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsOutreachOnsite" id="internsOutreachOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "internsOutreachFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsOutreachFinal" id="internsOutreachFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "internsOutreachOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsOutreachOffer" id="internsOutreachOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "internsOutreachAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsOutreachAccept" id="internsOutreachAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "internsOutreachDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsOutreachDecline" id="internsOutreachDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Hired
                    if($key == "internsHiredCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Hired</label></td>';
                        echo '<td><input type="number" class="input" name="internsHiredCandidates" id="internsHiredCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "internsHiredPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHiredPhone" id="internsHiredPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "internsHiredOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHiredOnsite" id="internsHiredOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "internsHiredFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHiredFinal" id="internsHiredFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "internsHiredOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHiredOffer" id="internsHiredOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "internsHiredAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHiredAccept" id="internsHiredAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "internsHiredDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHiredDecline" id="internsHiredDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Gogohire
                    if($key == "internsGogohireCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Gogohire</label></td>';
                        echo '<td><input type="number" class="input" name="internsGogohireCandidates" id="internsGogohireCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "internsGogohirePhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsGogohirePhone" id="internsGogohirePhone" value="'.$value.'"/></td>';
                    }
                    if($key == "internsGogohireOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsGogohireOnsite" id="internsGogohireOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "internsGogohireFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsGogohireFinal" id="internsGogohireFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "internsGogohireOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsGogohireOffer" id="internsGogohireOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "internsGogohireAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsGogohireAccept" id="internsGogohireAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "internsGogohireDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsGogohireDecline" id="internsGogohireDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //HireUp
                    if($key == "internsHireUpCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">HireUp</label></td>';
                        echo '<td><input type="number" class="input" name="internsHireUpCandidates" id="internsHireUpCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "internsHireUpPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHireUpPhone" id="internsHireUpPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "internsHireUpOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHireUpOnsite" id="internsHireUpOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "internsHireUpFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHireUpFinal" id="internsHireUpFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "internsHireUpOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHireUpOffer" id="internsHireUpOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "internsHireUpAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHireUpAccept" id="internsHireUpAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "internsHireUpDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsHireUpDecline" id="internsHireUpDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';
                    }

                    //Conferences
                    if($key == "internsConferencesCandidates" AND !is_numeric($key)) {
                        echo '<tr>
                              <td><label class="labelTD">Conferences</label></td>';
                        echo '<td><input type="number" class="input" name="internsConferencesCandidates" id="internsConferencesCandidates" value="'.$value.'"/></td>';
                    }
                    if($key == "internsConferencesPhone" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsConferencesPhone" id="internsConferencesPhone" value="'.$value.'"/></td>';
                    }
                    if($key == "internsConferencesOnsite" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsConferencesOnsite" id="internsConferencesOnsite" value="'.$value.'"/></td>';
                    }
                    if($key == "internsConferencesFinal" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsConferencesFinal" id="internsConferencesFinal" value="'.$value.'"/></td>';
                    } 
                    if($key == "internsConferencesOffer" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsConferencesOffer" id="internsConferencesOffer" value="'.$value.'"/></td>';
                    }
                    if($key == "internsConferencesAccept" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsConferencesAccept" id="internsConferencesAccept" value="'.$value.'"/></td>';
                    }
                    if($key == "internsConferencesDecline" AND !is_numeric($key)) {
                        echo '<td><input type="number" class="input" name="internsConferencesDecline" id="internsConferencesDecline"   value="'.$value.'"/></td>';
                        echo '</tr>';

                        echo '
                        </tbody>
                        </table>
                        </div>
                        ';                                    
                    }

                    $result = NULL;
                }
                break;
            }

        }
    ?>
            
        <div id="centerDiv2">
        </div>
    </div>
</form>

</body>
</html>
