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
    <link rel="stylesheet" type="text/css" href="/style/statsStyles.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="../bootstrap-3.3.6/js/bootstrap.min.js"></script>
    <script src="../js/addCandidate.js" type="text/javascript"></script>
    <title>Enter Monthly Recruiting Stats</title>
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
            <table id="addTable">
                <tr class="errorRow"><label class="errorLabel">
                    <script>
                        var param = window.location.href.split("id=");
                        if(param[1].toLowerCase() === "yes"){
                            document.write("Stats successfully added!");
                        } else if (param[1].toLowerCase() === "invaliddate") {
                            document.write("Enter valid month and year!");
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
                            <option selected value="0">--- Select Month ---</option>
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
                        <button id="addStatsButton" name="addStatsButton">Add New Stats</button>
                    </td>
                </tr>
            </table> 
        </div>
        

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
        <tr>
            <td><label class="labelTD">Referral</label></td>
            <td><input type="number" class="input" name="salesReferralCandidates" id="salesReferralCandidates"/></td>
            <td><input type="number" class="input" name="salesReferralPhone" id="salesReferralPhone"/></td>
            <td><input type="number" class="input" name="salesReferralOnsite" id="salesReferralOnsite"/></td>
            <td><input type="number" class="input" name="salesReferralFinal" id="salesReferralFinal"/></td>
            <td><input type="number" class="input" name="salesReferralOffer" id="salesReferralOffer"/></td>
            <td><input type="number" class="input" name="salesReferralAccept" id="salesReferralAccept"/></td>
            <td><input type="number" class="input" name="salesReferralDecline" id="salesReferralDecline"/></td>
        </tr>
        <tr>
            <td><label class="labelTD">Angel List</label></td>
            <td><input type="number" class="input" name="salesAngelListCandidates" id="salesAngelListCandidates"/></td>
            <td><input type="number" class="input" name="salesAngelListPhone" id="salesAngelListPhone"/></td>
            <td><input type="number" class="input" name="salesAngelListOnsite" id="salesAngelListOnsite"/></td>
            <td><input type="number" class="input" name="salesAngelListFinal" id="salesAngelListFinal"/></td>
            <td><input type="number" class="input" name="salesAngelListOffer" id="salesAngelListOffer"/></td>
            <td><input type="number" class="input" name="salesAngelListAccept" id="salesAngelListAccept"/></td>
            <td><input type="number" class="input" name="salesAngelListDecline" id="salesAngelListDecline"/></td>
        </tr>
        <tr>
            <td><label class="labelTD">Career Site</label></td>
            <td><input type="number" class="input" name="salesCareerSiteCandidates" id="salesCareerSiteCandidates"/></td>
            <td><input type="number" class="input" name="salesCareerSitePhone" id="salesCareerSitePhone"/></td>
            <td><input type="number" class="input" name="salesCareerSiteOnsite" id="salesCareerSiteOnsite"/></td>
            <td><input type="number" class="input" name="salesCareerSiteFinal" id="salesCareerSiteFinal"/></td>
            <td><input type="number" class="input" name="salesCareerSiteOffer" id="salesCareerSiteOffer"/></td>
            <td><input type="number" class="input" name="salesCareerSiteAccept" id="salesCareerSiteAccept"/></td>
            <td><input type="number" class="input" name="salesCareerSiteDecline" id="salesCareerSiteDecline"/></td>
        </tr>
        <tr>
            <td><label class="labelTD">Outreach</label></td>
            <td><input type="number" class="input" name="salesOutreachCandidates" id="salesOutreachCandidates"/></td>
            <td><input type="number" class="input" name="salesOutreachPhone" id="salesOutreachPhone"/></td>
            <td><input type="number" class="input" name="salesOutreachOnsite" id="salesOutreachOnsite"/></td>
            <td><input type="number" class="input" name="salesOutreachFinal" id="salesOutreachFinal"/></td>
            <td><input type="number" class="input" name="salesOutreachOffer" id="salesOutreachOffer"/></td>
            <td><input type="number" class="input" name="salesOutreachAccept" id="salesOutreachAccept"/></td>
            <td><input type="number" class="input" name="salesOutreachDecline" id="salesOutreachDecline"/></td>
        </tr>
        <tr>
            <td><label class="labelTD">Hired</label></td>
            <td><input type="number" class="input" name="salesHiredCandidates" id="salesHiredCandidates"/></td>
            <td><input type="number" class="input" name="salesHiredPhone" id="salesHiredPhone"/></td>
            <td><input type="number" class="input" name="salesHiredOnsite" id="salesHiredOnsite"/></td>
            <td><input type="number" class="input" name="salesHiredFinal" id="salesHiredFinal"/></td>
            <td><input type="number" class="input" name="salesHiredOffer" id="salesHiredOffer"/></td>
            <td><input type="number" class="input" name="salesHiredAccept" id="salesHiredAccept"/></td>
            <td><input type="number" class="input" name="salesHiredDecline" id="salesHiredDecline"/></td>
        </tr>
        <tr>
            <td><label class="labelTD">Gogohire</label></td>
            <td><input type="number" class="input" name="salesGogohireCandidates" id="salesGogohireCandidates"/></td>
            <td><input type="number" class="input" name="salesGogohirePhone" id="salesGogohirePhone"/></td>
            <td><input type="number" class="input" name="salesGogohireOnsite" id="salesGogohireOnsite"/></td>
            <td><input type="number" class="input" name="salesGogohireFinal" id="salesGogohireFinal"/></td>
            <td><input type="number" class="input" name="salesGogohireOffer" id="salesGogohireOffer"/></td>
            <td><input type="number" class="input" name="salesGogohireAccept" id="salesGogohireAccept"/></td>
            <td><input type="number" class="input" name="salesGogohireDecline" id="salesGogohireDecline"/></td>
        </tr>
        <tr>
            <td><label class="labelTD">HireUp</label></td>
            <td><input type="number" class="input" name="salesHireUpCandidates" id="salesHireUpCandidates"/></td>
            <td><input type="number" class="input" name="salesHireUpPhone" id="salesHireUpPhone"/></td>
            <td><input type="number" class="input" name="salesHireUpOnsite" id="salesHireUpOnsite"/></td>
            <td><input type="number" class="input" name="salesHireUpFinal" id="salesHireUpFinal"/></td>
            <td><input type="number" class="input" name="salesHireUpOffer" id="salesHireUpOffer"/></td>
            <td><input type="number" class="input" name="salesHireUpAccept" id="salesHireUpAccept"/></td>
            <td><input type="number" class="input" name="salesHireUpDecline" id="salesHireUpDecline"/></td>
        </tr>
        <tr>
            <td><label class="labelTD">Conferences</label></td>
            <td><input type="number" class="input" name="salesConferencesCandidates" id="salesConferencesCandidates"/></td>
            <td><input type="number" class="input" name="salesConferencesPhone" id="salesConferencesPhone"/></td>
            <td><input type="number" class="input" name="salesConferencesOnsite" id="salesConferencesOnsite"/></td>
            <td><input type="number" class="input" name="salesConferencesFinal" id="salesConferencesFinal"/></td>
            <td><input type="number" class="input" name="salesConferencesOffer" id="salesConferencesOffer"/></td>
            <td><input type="number" class="input" name="salesConferencesAccept" id="salesConferencesAccept"/></td>
            <td><input type="number" class="input" name="salesConferencesDecline" id="salesConferencesDecline"/></td>
        </tr>
    </tbody>
</table>
</div>
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
            <tr>
                <td><label class="labelTD">Referral</label></td>
                <td><input type="number" class="input" name="engReferralCandidates" id="engReferralCandidates"/></td>
                <td><input type="number" class="input" name="engReferralPhone" id="engReferralPhone"/></td>
                <td><input type="number" class="input" name="engReferralOnsite" id="engReferralOnsite"/></td>
                <td><input type="number" class="input" name="engReferralFinal" id="engReferralFinal"/></td>
                <td><input type="number" class="input" name="engReferralOffer" id="engReferralOffer"/></td>
                <td><input type="number" class="input" name="engReferralAccept" id="engReferralAccept"/></td>
                <td><input type="number" class="input" name="engReferralDecline" id="engReferralDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Angel List</label></td>
                <td><input type="number" class="input" name="engAngelListCandidates" id="engAngelListCandidates"/></td>
                <td><input type="number" class="input" name="engAngelListPhone" id="engAngelListPhone"/></td>
                <td><input type="number" class="input" name="engAngelListOnsite" id="engAngelListOnsite"/></td>
                <td><input type="number" class="input" name="engAngelListFinal" id="engAngelListFinal"/></td>
                <td><input type="number" class="input" name="engAngelListOffer" id="engAngelListOffer"/></td>
                <td><input type="number" class="input" name="engAngelListAccept" id="engAngelListAccept"/></td>
                <td><input type="number" class="input" name="engAngelListDecline" id="engAngelListDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Career Site</label></td>
                <td><input type="number" class="input" name="engCareerSiteCandidates" id="engCareerSiteCandidates"/></td>
                <td><input type="number" class="input" name="engCareerSitePhone" id="engCareerSitePhone"/></td>
                <td><input type="number" class="input" name="engCareerSiteOnsite" id="engCareerSiteOnsite"/></td>
                <td><input type="number" class="input" name="engCareerSiteFinal" id="engCareerSiteFinal"/></td>
                <td><input type="number" class="input" name="engCareerSiteOffer" id="engCareerSiteOffer"/></td>
                <td><input type="number" class="input" name="engCareerSiteAccept" id="engCareerSiteAccept"/></td>
                <td><input type="number" class="input" name="engCareerSiteDecline" id="engCareerSiteDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Outreach</label></td>
                <td><input type="number" class="input" name="engOutreachCandidates" id="engOutreachCandidates"/></td>
                <td><input type="number" class="input" name="engOutreachPhone" id="engOutreachPhone"/></td>
                <td><input type="number" class="input" name="engOutreachOnsite" id="engOutreachOnsite"/></td>
                <td><input type="number" class="input" name="engOutreachFinal" id="engOutreachFinal"/></td>
                <td><input type="number" class="input" name="engOutreachOffer" id="engOutreachOffer"/></td>
                <td><input type="number" class="input" name="engOutreachAccept" id="engOutreachAccept"/></td>
                <td><input type="number" class="input" name="engOutreachDecline" id="engOutreachDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Hired</label></td>
                <td><input type="number" class="input" name="engHiredCandidates" id="engHiredCandidates"/></td>
                <td><input type="number" class="input" name="engHiredPhone" id="engHiredPhone"/></td>
                <td><input type="number" class="input" name="engHiredOnsite" id="engHiredOnsite"/></td>
                <td><input type="number" class="input" name="engHiredFinal" id="engHiredFinal"/></td>
                <td><input type="number" class="input" name="engHiredOffer" id="engHiredOffer"/></td>
                <td><input type="number" class="input" name="engHiredAccept" id="engHiredAccept"/></td>
                <td><input type="number" class="input" name="engHiredDecline" id="engHiredDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Gogohire</label></td>
                <td><input type="number" class="input" name="engGogohireCandidates" id="engGogohireCandidates"/></td>
                <td><input type="number" class="input" name="engGogohirePhone" id="engGogohirePhone"/></td>
                <td><input type="number" class="input" name="engGogohireOnsite" id="engGogohireOnsite"/></td>
                <td><input type="number" class="input" name="engGogohireFinal" id="engGogohireFinal"/></td>
                <td><input type="number" class="input" name="engGogohireOffer" id="engGogohireOffer"/></td>
                <td><input type="number" class="input" name="engGogohireAccept" id="engGogohireAccept"/></td>
                <td><input type="number" class="input" name="engGogohireDecline" id="engGogohireDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">HireUp</label></td>
                <td><input type="number" class="input" name="engHireUpCandidates" id="engHireUpCandidates"/></td>
                <td><input type="number" class="input" name="engHireUpPhone" id="engHireUpPhone"/></td>
                <td><input type="number" class="input" name="engHireUpOnsite" id="engHireUpOnsite"/></td>
                <td><input type="number" class="input" name="engHireUpFinal" id="engHireUpFinal"/></td>
                <td><input type="number" class="input" name="engHireUpOffer" id="engHireUpOffer"/></td>
                <td><input type="number" class="input" name="engHireUpAccept" id="engHireUpAccept"/></td>
                <td><input type="number" class="input" name="engHireUpDecline" id="engHireUpDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Conferences</label></td>
                <td><input type="number" class="input" name="engConferencesCandidates" id="engConferencesCandidates"/></td>
                <td><input type="number" class="input" name="engConferencesPhone" id="engConferencesPhone"/></td>
                <td><input type="number" class="input" name="engConferencesOnsite" id="engConferencesOnsite"/></td>
                <td><input type="number" class="input" name="engConferencesFinal" id="engConferencesFinal"/></td>
                <td><input type="number" class="input" name="engConferencesOffer" id="engConferencesOffer"/></td>
                <td><input type="number" class="input" name="engConferencesAccept" id="engConferencesAccept"/></td>
                <td><input type="number" class="input" name="engConferencesDecline" id="engConferencesDecline"/></td>
            </tr>
        </tbody>
    </table>
</div>
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
            <tr>
                <td><label class="labelTD">Referral</label></td>
                <td><input type="number" class="input" name="csmReferralCandidates" id="csmReferralCandidates"/></td>
                <td><input type="number" class="input" name="csmReferralPhone" id="csmReferralPhone"/></td>
                <td><input type="number" class="input" name="csmReferralOnsite" id="csmReferralOnsite"/></td>
                <td><input type="number" class="input" name="csmReferralFinal" id="csmReferralFinal"/></td>
                <td><input type="number" class="input" name="csmReferralOffer" id="csmReferralOffer"/></td>
                <td><input type="number" class="input" name="csmReferralAccept" id="csmReferralAccept"/></td>
                <td><input type="number" class="input" name="csmReferralDecline" id="csmReferralDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Angel List</label></td>
                <td><input type="number" class="input" name="csmAngelListCandidates" id="csmAngelListCandidates"/></td>
                <td><input type="number" class="input" name="csmAngelListPhone" id="csmAngelListPhone"/></td>
                <td><input type="number" class="input" name="csmAngelListOnsite" id="csmAngelListOnsite"/></td>
                <td><input type="number" class="input" name="csmAngelListFinal" id="csmAngelListFinal"/></td>
                <td><input type="number" class="input" name="csmAngelListOffer" id="csmAngelListOffer"/></td>
                <td><input type="number" class="input" name="csmAngelListAccept" id="csmAngelListAccept"/></td>
                <td><input type="number" class="input" name="csmAngelListDecline" id="csmAngelListDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Career Site</label></td>
                <td><input type="number" class="input" name="csmCareerSiteCandidates" id="csmCareerSiteCandidates"/></td>
                <td><input type="number" class="input" name="csmCareerSitePhone" id="csmCareerSitePhone"/></td>
                <td><input type="number" class="input" name="csmCareerSiteOnsite" id="csmCareerSiteOnsite"/></td>
                <td><input type="number" class="input" name="csmCareerSiteFinal" id="csmCareerSiteFinal"/></td>
                <td><input type="number" class="input" name="csmCareerSiteOffer" id="csmCareerSiteOffer"/></td>
                <td><input type="number" class="input" name="csmCareerSiteAccept" id="csmCareerSiteAccept"/></td>
                <td><input type="number" class="input" name="csmCareerSiteDecline" id="csmCareerSiteDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Outreach</label></td>
                <td><input type="number" class="input" name="csmOutreachCandidates" id="csmOutreachCandidates"/></td>
                <td><input type="number" class="input" name="csmOutreachPhone" id="csmOutreachPhone"/></td>
                <td><input type="number" class="input" name="csmOutreachOnsite" id="csmOutreachOnsite"/></td>
                <td><input type="number" class="input" name="csmOutreachFinal" id="csmOutreachFinal"/></td>
                <td><input type="number" class="input" name="csmOutreachOffer" id="csmOutreachOffer"/></td>
                <td><input type="number" class="input" name="csmOutreachAccept" id="csmOutreachAccept"/></td>
                <td><input type="number" class="input" name="csmOutreachDecline" id="csmOutreachDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Hired</label></td>
                <td><input type="number" class="input" name="csmHiredCandidates" id="csmHiredCandidates"/></td>
                <td><input type="number" class="input" name="csmHiredPhone" id="csmHiredPhone"/></td>
                <td><input type="number" class="input" name="csmHiredOnsite" id="csmHiredOnsite"/></td>
                <td><input type="number" class="input" name="csmHiredFinal" id="csmHiredFinal"/></td>
                <td><input type="number" class="input" name="csmHiredOffer" id="csmHiredOffer"/></td>
                <td><input type="number" class="input" name="csmHiredAccept" id="csmHiredAccept"/></td>
                <td><input type="number" class="input" name="csmHiredDecline" id="csmHiredDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Gogohire</label></td>
                <td><input type="number" class="input" name="csmGogohireCandidates" id="csmGogohireCandidates"/></td>
                <td><input type="number" class="input" name="csmGogohirePhone" id="csmGogohirePhone"/></td>
                <td><input type="number" class="input" name="csmGogohireOnsite" id="csmGogohireOnsite"/></td>
                <td><input type="number" class="input" name="csmGogohireFinal" id="csmGogohireFinal"/></td>
                <td><input type="number" class="input" name="csmGogohireOffer" id="csmGogohireOffer"/></td>
                <td><input type="number" class="input" name="csmGogohireAccept" id="csmGogohireAccept"/></td>
                <td><input type="number" class="input" name="csmGogohireDecline" id="csmGogohireDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">HireUp</label></td>
                <td><input type="number" class="input" name="csmHireUpCandidates" id="csmHireUpCandidates"/></td>
                <td><input type="number" class="input" name="csmHireUpPhone" id="csmHireUpPhone"/></td>
                <td><input type="number" class="input" name="csmHireUpOnsite" id="csmHireUpOnsite"/></td>
                <td><input type="number" class="input" name="csmHireUpFinal" id="csmHireUpFinal"/></td>
                <td><input type="number" class="input" name="csmHireUpOffer" id="csmHireUpOffer"/></td>
                <td><input type="number" class="input" name="csmHireUpAccept" id="csmHireUpAccept"/></td>
                <td><input type="number" class="input" name="csmHireUpDecline" id="csmHireUpDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Conferences</label></td>
                <td><input type="number" class="input" name="csmConferencesCandidates" id="csmConferencesCandidates"/></td>
                <td><input type="number" class="input" name="csmConferencesPhone" id="csmConferencesPhone"/></td>
                <td><input type="number" class="input" name="csmConferencesOnsite" id="csmConferencesOnsite"/></td>
                <td><input type="number" class="input" name="csmConferencesFinal" id="csmConferencesFinal"/></td>
                <td><input type="number" class="input" name="csmConferencesOffer" id="csmConferencesOffer"/></td>
                <td><input type="number" class="input" name="csmConferencesAccept" id="csmConferencesAccept"/></td>
                <td><input type="number" class="input" name="csmConferencesDecline" id="csmConferencesDecline"/></td>
            </tr>
        </tbody>
    </table>
</div>
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
           <tr>
                <td><label class="labelTD">Referral</label></td>
                <td><input type="number" class="input" name="internsReferralCandidates" id="internsReferralCandidates"/></td>
                <td><input type="number" class="input" name="internsReferralPhone" id="internsReferralPhone"/></td>
                <td><input type="number" class="input" name="internsReferralOnsite" id="internsReferralOnsite"/></td>
                <td><input type="number" class="input" name="internsReferralFinal" id="internsReferralFinal"/></td>
                <td><input type="number" class="input" name="internsReferralOffer" id="internsReferralOffer"/></td>
                <td><input type="number" class="input" name="internsReferralAccept" id="internsReferralAccept"/></td>
                <td><input type="number" class="input" name="internsReferralDecline" id="internsReferralDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Angel List</label></td>
                <td><input type="number" class="input" name="internsAngelListCandidates" id="internsAngelListCandidates"/></td>
                <td><input type="number" class="input" name="internsAngelListPhone" id="internsAngelListPhone"/></td>
                <td><input type="number" class="input" name="internsAngelListOnsite" id="internsAngelListOnsite"/></td>
                <td><input type="number" class="input" name="internsAngelListFinal" id="internsAngelListFinal"/></td>
                <td><input type="number" class="input" name="internsAngelListOffer" id="internsAngelListOffer"/></td>
                <td><input type="number" class="input" name="internsAngelListAccept" id="internsAngelListAccept"/></td>
                <td><input type="number" class="input" name="internsAngelListDecline" id="internsAngelListDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Career Site</label></td>
                <td><input type="number" class="input" name="internsCareerSiteCandidates" id="internsCareerSiteCandidates"/></td>
                <td><input type="number" class="input" name="internsCareerSitePhone" id="internsCareerSitePhone"/></td>
                <td><input type="number" class="input" name="internsCareerSiteOnsite" id="internsCareerSiteOnsite"/></td>
                <td><input type="number" class="input" name="internsCareerSiteFinal" id="internsCareerSiteFinal"/></td>
                <td><input type="number" class="input" name="internsCareerSiteOffer" id="internsCareerSiteOffer"/></td>
                <td><input type="number" class="input" name="internsCareerSiteAccept" id="internsCareerSiteAccept"/></td>
                <td><input type="number" class="input" name="internsCareerSiteDecline" id="internsCareerSiteDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Outreach</label></td>
                <td><input type="number" class="input" name="internsOutreachCandidates" id="internsOutreachCandidates"/></td>
                <td><input type="number" class="input" name="internsOutreachPhone" id="internsOutreachPhone"/></td>
                <td><input type="number" class="input" name="internsOutreachOnsite" id="internsOutreachOnsite"/></td>
                <td><input type="number" class="input" name="internsOutreachFinal" id="internsOutreachFinal"/></td>
                <td><input type="number" class="input" name="internsOutreachOffer" id="internsOutreachOffer"/></td>
                <td><input type="number" class="input" name="internsOutreachAccept" id="internsOutreachAccept"/></td>
                <td><input type="number" class="input" name="internsOutreachDecline" id="internsOutreachDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Hired</label></td>
                <td><input type="number" class="input" name="internsHiredCandidates" id="internsHiredCandidates"/></td>
                <td><input type="number" class="input" name="internsHiredPhone" id="internsHiredPhone"/></td>
                <td><input type="number" class="input" name="internsHiredOnsite" id="internsHiredOnsite"/></td>
                <td><input type="number" class="input" name="internsHiredFinal" id="internsHiredFinal"/></td>
                <td><input type="number" class="input" name="internsHiredOffer" id="internsHiredOffer"/></td>
                <td><input type="number" class="input" name="internsHiredAccept" id="internsHiredAccept"/></td>
                <td><input type="number" class="input" name="internsHiredDecline" id="internsHiredDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Gogohire</label></td>
                <td><input type="number" class="input" name="internsGogohireCandidates" id="internsGogohireCandidates"/></td>
                <td><input type="number" class="input" name="internsGogohirePhone" id="internsGogohirePhone"/></td>
                <td><input type="number" class="input" name="internsGogohireOnsite" id="internsGogohireOnsite"/></td>
                <td><input type="number" class="input" name="internsGogohireFinal" id="internsGogohireFinal"/></td>
                <td><input type="number" class="input" name="internsGogohireOffer" id="internsGogohireOffer"/></td>
                <td><input type="number" class="input" name="internsGogohireAccept" id="internsGogohireAccept"/></td>
                <td><input type="number" class="input" name="internsGogohireDecline" id="internsGogohireDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">HireUp</label></td>
                <td><input type="number" class="input" name="internsHireUpCandidates" id="internsHireUpCandidates"/></td>
                <td><input type="number" class="input" name="internsHireUpPhone" id="internsHireUpPhone"/></td>
                <td><input type="number" class="input" name="internsHireUpOnsite" id="internsHireUpOnsite"/></td>
                <td><input type="number" class="input" name="internsHireUpFinal" id="internsHireUpFinal"/></td>
                <td><input type="number" class="input" name="internsHireUpOffer" id="internsHireUpOffer"/></td>
                <td><input type="number" class="input" name="internsHireUpAccept" id="internsHireUpAccept"/></td>
                <td><input type="number" class="input" name="internsHireUpDecline" id="internsHireUpDecline"/></td>
            </tr>
            <tr>
                <td><label class="labelTD">Conferences</label></td>
                <td><input type="number" class="input" name="internsConferencesCandidates" id="internsConferencesCandidates"/></td>
                <td><input type="number" class="input" name="internsConferencesPhone" id="internsConferencesPhone"/></td>
                <td><input type="number" class="input" name="internsConferencesOnsite" id="internsConferencesOnsite"/></td>
                <td><input type="number" class="input" name="internsConferencesFinal" id="internsConferencesFinal"/></td>
                <td><input type="number" class="input" name="internsConferencesOffer" id="internsConferencesOffer"/></td>
                <td><input type="number" class="input" name="internsConferencesAccept" id="internsConferencesAccept"/></td>
                <td><input type="number" class="input" name="internsConferencesDecline" id="internsConferencesDecline"/></td>
            </tr>
        </tbody>

            
            </table>
        </div>
    </div>
</div>
<div id="centerDiv2">

</div>
    </form>

</body>
    <?php
    session_write_close();
    ?>
</html>
