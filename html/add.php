<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap-3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/style/addStyles.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="../bootstrap-3.3.6/js/bootstrap.min.js"  type="text/javascript"></script>
    <script src="../js/addCandidate.js" type="text/javascript"></script>

    
    <title>Add Candidates</title>
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
                            document.write("Candidate successfully added!");
                        } else {
                            document.write("Error adding candidate!");
                        }
                    </script>
                    </label>
                </tr>
                <tr class="labelRow">
                    <td colspan="1"><label name="dateSourcedLabel" class="label">Date Sourced</label></td>
                    <td><label name="firstNameLabel" class="label">First Name</label></td>
                    <td><label name="lastNameLabel" class="label">Last Name</label></td>
                    <td><label name="employerNameLabel" class="label">Employer</label></td>
                    <td><label name="employerDateLabel" class="label">Join Date</label></td>
                </tr>
                <tr class="inputRow">
                    <td><input type="date" name="dateSourced" class="input"></td>
                    <td><input name="firstName" class="input"></td>
                    <td><input name="lastName" class="input"></td>
                    <td><input name="employerName" class="input"></td>
                   <td><input type="date" name="employerDate" class="input"></td>
                </tr>
                <tr class="labelRow">
                    <td colspan="3"><label name="emailLabel" class="label">Email</label></td>
                    <td colspan="3"><label name="linkedinLabel" class="label">LinkedIn</label></td>
<!--                    <td><label colspan="2" name="notesLabel" class="label">Notes</label></td>-->
                </tr>
                 <tr class="inputRow">
                    <td colspan="3"><input name="email" class="input" id="email" type="email"></td>
                    <td colspan="3"><input name="linkedin" class="input" id="linkedin"></td>
<!--                    <td rowspan="2"><textarea name="notes" class="textarea"></textarea></td>-->
                </tr>
                <tr class="labelRow">
                    <td><label name="roleLabel" class="roleLabel label">Role</label></td>
                    <td><label name="seniorityLabel" class="roleLabel label">Seniority</label></td>
                    <td><label name="genderLabel" class="roleLabel label">Gender</label></td>
                    <td><label colspan="3" name="notesLabel" class="label">Notes</label></td>
                </tr>
                <tr class="roleRow inputRow">
                    <td colspan="1" id="roleTD">
                        <select name="role" class="roleInput input">
                            <option value="">--- Select Role ---</option>
                            <option value="Data Engineer">Data Engineer</option>
                            <option value="Front-End Engineeer">Front-End Engineeer</option>
                            <option value="Back-End Engineer">Back-End Engineer</option>
                            <option value="SDR">SDR</option>
                            <option value="Account Executive">Account Executive</option>
                            <option value="CSM">CSM</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Finance">Finance</option>
                            <option value="Media">Media</option>
                        </select>
                    </td>
                    
                    <td colspan="1" id="seniorityTD">
                        <select name="seniority" class="roleInput input">
                            <option value="">--- Seniority ---</option>
                            <option value="Junior">Junior</option>
                            <option value="Mid-Level">Mid-Level</option>
                            <option value="Senior">Senior</option>
                        </select>
                    </td>
                    
                    <td colspan="1">
                        <select name="gender" class="roleInput input">
                            <option value="">--- Gender ---</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                            <option value="Self-Defined">Self-Defined</option>
                        </select>
                    </td>
                    <td rowspan="3" colspan="3"><textarea name="notes" class="textarea"></textarea></td>
                </tr>
            </table>
        </div>

        <hr/>

        <div id="centerDiv2">
            <table id="addTable2">
                <tr class="labelRow">
                    <td><label name="schoolLabel" class="label">School/College</label></td>
                    <td><label name="gradYearLabel" class="label">Graduation Year</label></td>
                    <td><label name="contactedLabel" class="radioLabel">Contacted?</label></td>
                    <td><label name="contactedDateLabel" class="label">Date Contacted</label></td>
                    <td><label name="followupLabel" class="radioLabel">Follow Up?</label></td>
                    <td><label name="followupDateLabel" class="label">Date Followed Up</label></td>
                </tr>
                <tr class="inputRow">
                    <td><input name="school" class="input"></td>
                    <td><input name="gradYear" class="input" type="number"></td>
                    <td class="radioTD"><input type="radio" name="contacted" value="FALSE" checked class="radioInput"> No
                        <input type="radio" name="contacted" value="TRUE" class="radioInput"> Yes
                    </td>
                    <td><input name="contactedDate" class="input" type="date"></td>
                   <td class="radioTD"><input type="radio" name="followup" value="FALSE" checked class="radioInput"> No
                        <input type="radio" name="followup" value="TRUE" class="radioInput"> Yes
                    </td>
                    <td><input name="followupDate" class="input" type="date"></td>
                </tr>
                <tr height="10px"></tr>
                  <tr class="buttonRow">
                    <td><button type="submit" name="addButton" id="addButton">Add Candidate</button></td>
                </tr>
            </table>  
        </div>
    </form>

</body>
</html>
