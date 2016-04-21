<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
error_reporting(E_ALL); ini_set('display_errors', 1);

if (isset($_REQUEST['addButton'])) {
    addCandidate();
} 

if (isset($_REQUEST['searchButton'])) {
    searchCandidate();
}

if (isset($_REQUEST['yearReportButton'])) {
    reportCandidate(1);
}

if (isset($_REQUEST['oneMonthFollowupButton'])) {
    reportCandidate(2);
}

if (isset($_REQUEST['threeMonthFollowupButton'])) {
    reportCandidate(3);
}

if (isset($_REQUEST['sixMonthFollowupButton'])) {
    reportCandidate(4);
}

if (isset($_REQUEST['yearFollowupButton'])) {
    reportCandidate(5);
}

if (isset($_REQUEST['allButton'])) {
    reportCandidate(6);
}

if (isset($_REQUEST['importButton'])) {
    importCandidate();
}

if (isset($_REQUEST['addStatsButton'])) {
    addStats();
}

if (isset($_REQUEST['editStatsButton'])) {
    editStats();
}

if (isset($_REQUEST['updateStatsButton'])) {
    updateStats();
}

if (isset($_REQUEST['allStatsButton'])) {
    reportStats(1);
}

$result = array();

function addCandidate() {
    
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "HR_DB";
    $port = 3306;

    $dateSourced = "";
    $firstName = "";
    $lastName = "";
    $employerName = "";
    $employerDate = "";
    $email = "";
    $linkedin = "";
    $notes = "";
    $role = "";
    $seniority = "";
    $gender = "";
    $school = "";
    $gradYear = "";
    $contacted = "";
    $contactedDate = "";
    $followup = "";
    $followupDate = "";

    $none = "";

    $dom = new DOMDocument();
    $path = "/Applications/AMPPS/www/html/add.php";
    $html = file_get_contents($path); 
    $dom->loadHTML($html);

    $input = $dom->getElementsByTagName('input');
    for($i=0; $i<$input->length; $i++){
        $name = $input->item($i)->getAttribute('name');
        if ($name == 'dateSourced' ? $dateSourced = $_POST[$name] : $none = "");
        if ($name == 'firstName' ? $firstName = $_POST[$name] : $none = "");
        if ($name == 'lastName' ? $lastName = $_POST[$name] : $none = "");
        if ($name == 'employerName' ? $employerName = $_POST[$name] : $none = "");
        if ($name == 'employerDate' ? $employerDate = $_POST[$name] : $none = "");
        if ($name == 'email' ? $email = $_POST[$name] : $none = "");
        if ($name == 'linkedin' ? $linkedin = $_POST[$name] : $none = "");
        if ($name == 'notes' ? $notes = $_POST[$name] : $none = "");
        if ($name == 'school' ? $school = $_POST[$name] : $none = "");
        if ($name == 'gradYear' ? $gradYear = $_POST[$name] : $none = "");
        if ($name == 'contacted' ? $contacted = $_POST[$name] : $none = "");
        if ($name == 'contactedDate' ? $contactedDate = $_POST[$name] : $none = "");
        if ($name == 'followup' ? $followup = $_POST[$name] : $none = "");
        if ($name == 'followupDate' ? $followupDate = $_POST[$name] : $none = "");    
    }

    $select = $dom->getElementsByTagName('select');
    for($i=0; $i<$select->length; $i++){
        $name = $select->item($i)->getAttribute('name');

        if ($name == 'role' ? $role = $_POST[$name] : $none = "");
        if ($name == 'seniority' ? $seniority = $_POST[$name] : $none = "");
        if ($name == 'gender' ? $gender = $_POST[$name] : $none = "");
    }
    
    if(strlen($dateSourced)>0){
        $dateSourced = fixDate($dateSourced);
    }
    
    if(strlen($employerDate)>0){
        $employerDate = fixDate($employerDate);
    }
    
    if(strlen($contactedDate)>0){
        $contactedDate = fixDate($contactedDate);
    }
    
    if(strlen($followupDate)>0){
        $followupDate = fixDate($followupDate);
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";

    $sql = "CREATE DATABASE HR_DB";

    $sql = "CREATE TABLE IF NOT EXISTS Candidates (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        dateSourced VARCHAR (30),
        firstName VARCHAR(30),
        lastName VARCHAR(30),
        employerName VARCHAR (30),
        employerDate VARCHAR (30),
        email VARCHAR(100),
        linkedin VARCHAR(200),
        notes TEXT,
        role VARCHAR (30),
        seniority VARCHAR (30),
        gender VARCHAR (30),
        school VARCHAR (100),
        gradYear VARCHAR (30),
        contacted VARCHAR (30),
        contactedDate VARCHAR (30),
        followup VARCHAR (30),
        followupDate VARCHAR (30),
    )";

    $sql = "INSERT INTO Candidates (dateSourced, firstName, lastName, employerName, employerDate, email, linkedin, 
    notes, role, seniority, gender, school, gradYear, contacted, contactedDate, followup, followupDate)
    VALUES ('$dateSourced', '$firstName', '$lastName', '$employerName', '$employerDate', '$email', '$linkedin', 
    '$notes', '$role', '$seniority', '$gender', '$school', '$gradYear', '$contacted', '$contactedDate', '$followup', '$followupDate')";

    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
        header("Location: ../html/add.php?id=yes");
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $conn->close();
    
}

function searchCandidate() {
    
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "HR_DB";
    $port = 3306;

    $dateSourced = "";
    $firstName = "";
    $lastName = "";
    $employerName = "";
    $employerDate = "";
    $email = "";
    $linkedin = "";
    $notes = "";
    $role = "";
    $seniority = "";
    $gender = "";
    $school = "";
    $gradYear = "";
    $contacted = "";
    $contactedDate = "";
    $followup = "";
    $followupDate = "";

    $none = "";

    $dom = new DOMDocument();
    $path = "/Applications/AMPPS/www/html/search.php";
    $html = file_get_contents($path); 
    $dom->loadHTML($html);

    $input = $dom->getElementsByTagName('input');
    for($i=0; $i<$input->length; $i++){
        $name = $input->item($i)->getAttribute('name');
        if ($name == 'dateSourced' ? $dateSourced = $_POST[$name] : $none = "");
        if ($name == 'firstName' ? $firstName = $_POST[$name] : $none = "");
        if ($name == 'lastName' ? $lastName = $_POST[$name] : $none = "");
        if ($name == 'employerName' ? $employerName = $_POST[$name] : $none = "");
        if ($name == 'employerDate' ? $employerDate = $_POST[$name] : $none = "");
        if ($name == 'email' ? $email = $_POST[$name] : $none = "");
        if ($name == 'linkedin' ? $linkedin = $_POST[$name] : $none = "");
        if ($name == 'notes' ? $notes = $_POST[$name] : $none = "");
        if ($name == 'school' ? $school = $_POST[$name] : $none = "");
        if ($name == 'gradYear' ? $gradYear = $_POST[$name] : $none = "");
        if ($name == 'contacted' ? $contacted = $_POST[$name] : $none = "");
        if ($name == 'contactedDate' ? $contactedDate = $_POST[$name] : $none = "");
        if ($name == 'followup' ? $followup = $_POST[$name] : $none = "");
        if ($name == 'followupDate' ? $followupDate = $_POST[$name] : $none = "");    
    }

    $select = $dom->getElementsByTagName('select');
    for($i=0; $i<$select->length; $i++){
        $name = $select->item($i)->getAttribute('name');

        if ($name == 'role' ? $role = $_POST[$name]  : $none = "");
        if ($name == 'seniority' ? $seniority = $_POST[$name]  : $none = "");
        if ($name == 'gender' ? $gender = $_POST[$name] : $none = "");
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";

    $whereStr = "";
    
    if(strlen($firstName)>0){
        strlen($whereStr)>0 ? $whereStr = $whereStr." AND"." firstName='$firstName'" : $whereStr = $whereStr." firstName='$firstName'";
    }
    
    if(strlen($lastName)>0){
        strlen($whereStr)>0 ? $whereStr = $whereStr." AND"." lastName='$lastName'" : $whereStr = $whereStr." lastName='$lastName'";
    }
    
    if(strlen($employerName)>0){
        strlen($whereStr)>0 ? $whereStr = $whereStr." AND"." employerName='$employerName'" : $whereStr = $whereStr." employerName='$employerName'";
    }
    
    if(strlen($employerDate)>0){
        strlen($whereStr)>0 ? $whereStr = $whereStr." AND"." employerDate='$employerDate'" : $whereStr = $whereStr." employerDate='$employerDate'";
    }
    
    if(strlen($role)>0){
        strlen($whereStr)>0 ? $whereStr = $whereStr." AND"." role='$role'" : $whereStr = $whereStr." role='$role'";
    }
    
    if(strlen($seniority)>0){
        strlen($whereStr)>0 ? $whereStr = $whereStr." AND"." seniority='$seniority'" : $whereStr = $whereStr." seniority='$seniority'";
    }

    if (strlen($whereStr)>0){
        $sql = "SELECT * FROM Candidates WHERE".$whereStr;
    } else {
        $sql = "SELECT * FROM Candidates";
    }
    
    $result = $conn->query($sql);
    
    class Candidate {
        public $dateSourcedObj = "";
        public $firstNameObj = "";
        public $lastNameObj = "";
        public $employerNameObj = "";
        public $employerDateObj = "";
        public $emailObj = "";
        public $linkedinObj = "";
        public $notesObj = "";
        public $roleObj = "";
        public $seniorityObj = "";
        public $genderObj = "";
        public $schoolObj = "";
        public $gradYearObj = "";
        public $contactedObj = "";
        public $contactedDateObj = "";
        public $followupObj = "";
        public $followupDateObj = "";
    }
    
    $resultArray = array();
    
    while($row = mysqli_fetch_array($result)) {
        $candidate = new Candidate();
        $candidate->dateSourcedObj = (string)$row['dateSourced'];
        $candidate->firstNameObj = $row['firstName'];
        $candidate->lastNameObj = $row['lastName'];
        $candidate->employerNameObj = $row['employerName'];
        $candidate->employerDateObj = (string)$row['employerDate'];
        $candidate->emailObj = $row['email'];
        $candidate->linkedinObj = $row['linkedin'];
        $candidate->notesObj = $row['notes'];
        $candidate->roleObj = $row['role'];
        $candidate->seniorityObj = $row['seniority'];
        $candidate->genderObj = $row['gender'];
        $candidate->schoolObj = $row['school'];
        $candidate->gradYearObj = (string)$row['gradYear'];
        $candidate->contactedObj = $row['contacted'];
        $candidate->contactedDateObj = $row['contactedDate'];
        $candidate->followupObj = $row['followup'];
        $candidate->followupDateObj = (string)$row['followupDate'];
        array_push($resultArray, $candidate);
    }
       
    if(count($resultArray)>0){
        $_SESSION['resultArray'] = $resultArray;
        $result = $resultArray;
        header("Location: ../html/search.php");
    } else {
         $_SESSION['resultArray'] = $resultArray;
        $result = $resultArray;
        header("Location: ../html/search.php");
    }
    $conn->close();
}

function reportCandidate($flag) {
    
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "HR_DB";
    $port = 3306;

    $dateSourced = "";
    $firstName = "";
    $lastName = "";
    $employerName = "";
    $employerDate = "";
    $email = "";
    $linkedin = "";
    $notes = "";
    $role = "";
    $seniority = "";
    $gender = "";
    $school = "";
    $gradYear = "";
    $contacted = "";
    $contactedDate = "";
    $followup = "";
    $followupDate = "";

    $none = "";

    $dom = new DOMDocument();
    $path = "/Applications/AMPPS/www/html/report.php";
    $html = file_get_contents($path); 
    $dom->loadHTML($html);

    $input = $dom->getElementsByTagName('input');
    for($i=0; $i<$input->length; $i++){
        $name = $input->item($i)->getAttribute('name');
        if ($name == 'dateSourced' ? $dateSourced = $_POST[$name] : $none = "");
        if ($name == 'firstName' ? $firstName = $_POST[$name] : $none = "");
        if ($name == 'lastName' ? $lastName = $_POST[$name] : $none = "");
        if ($name == 'employerName' ? $employerName = $_POST[$name] : $none = "");
        if ($name == 'employerDate' ? $employerDate = $_POST[$name] : $none = "");
        if ($name == 'email' ? $email = $_POST[$name] : $none = "");
        if ($name == 'linkedin' ? $linkedin = $_POST[$name] : $none = "");
        if ($name == 'notes' ? $notes = $_POST[$name] : $none = "");
        if ($name == 'school' ? $school = $_POST[$name] : $none = "");
        if ($name == 'gradYear' ? $gradYear = $_POST[$name] : $none = "");
        if ($name == 'contacted' ? $contacted = $_POST[$name] : $none = "");
        if ($name == 'contactedDate' ? $contactedDate = $_POST[$name] : $none = "");
        if ($name == 'followup' ? $followup = $_POST[$name] : $none = "");
        if ($name == 'followupDate' ? $followupDate = $_POST[$name] : $none = "");    
    }

    $select = $dom->getElementsByTagName('select');
    for($i=0; $i<$select->length; $i++){
        $name = $select->item($i)->getAttribute('name');

        if ($name == 'role' ? $role = $_POST[$name]  : $none = "");
        if ($name == 'seniority' ? $seniority = $_POST[$name]  : $none = "");
        if ($name == 'gender' ? $gender = $_POST[$name] : $none = "");
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";
    
    date_default_timezone_set('America/Los_Angeles');
    $monthToday = date('n', time());
    
    switch ($flag){
        case 1:
            $sql = "SELECT * FROM Candidates WHERE MONTH(STR_TO_DATE(employerDate, '%d.%m.%y'))=".$monthToday." OR MONTH(STR_TO_DATE(employerDate, '%Y-%m-%d'))=".$monthToday;
            break;
        case 2:
            $sql = "SELECT * FROM Candidates WHERE MTIMESTAMPDIFF(MONTH, followupDate,CURDATE())=1";
            break;
        case 3:
            $sql = "SELECT * FROM Candidates WHERE TIMESTAMPDIFF(MONTH, followupDate, CURDATE())=3";
            break;
        case 4:
            $sql = "SELECT * FROM Candidates WHERE TIMESTAMPDIFF(MONTH, followupDate,CURDATE())=6";
            break;
        case 5:
            $sql = "SELECT * FROM Candidates WHERE TIMESTAMPDIFF(MONTH, followupDate,CURDATE())>11";
            break;
        case 6:
            $sql = "SELECT * FROM Candidates";
            break;
        default:
            $sql = "SELECT * FROM Candidates";
            break;
    }
    
    $result = $conn->query($sql);
    
    class Candidate {
        public $dateSourcedObj = "";
        public $firstNameObj = "";
        public $lastNameObj = "";
        public $employerNameObj = "";
        public $employerDateObj = "";
        public $emailObj = "";
        public $linkedinObj = "";
        public $notesObj = "";
        public $roleObj = "";
        public $seniorityObj = "";
        public $genderObj = "";
        public $schoolObj = "";
        public $gradYearObj = "";
        public $contactedObj = "";
        public $contactedDateObj = "";
        public $followupObj = "";
        public $followupDateObj = "";
    }
    
    $resultArray = array();
    
    while($row = mysqli_fetch_array($result)) {
        $candidate = new Candidate();
        $candidate->dateSourcedObj = (string)$row['dateSourced'];
        $candidate->firstNameObj = $row['firstName'];
        $candidate->lastNameObj = $row['lastName'];
        $candidate->employerNameObj = $row['employerName'];
        $candidate->employerDateObj = (string)$row['employerDate'];
        $candidate->emailObj = $row['email'];
        $candidate->linkedinObj = $row['linkedin'];
        $candidate->notesObj = $row['notes'];
        $candidate->roleObj = $row['role'];
        $candidate->seniorityObj = $row['seniority'];
        $candidate->genderObj = $row['gender'];
        $candidate->schoolObj = $row['school'];
        $candidate->gradYearObj = (string)$row['gradYear'];
        $candidate->contactedObj = $row['contacted'];
        $candidate->contactedDateObj = $row['contactedDate'];
        $candidate->followupObj = $row['followup'];
        $candidate->followupDateObj = (string)$row['followupDate'];
        array_push($resultArray, $candidate);
    }
       
    if(count($resultArray)>0){
        $_SESSION['resultArray'] = $resultArray;
        $result = $resultArray;
        header("Location: ../html/report.php");
    }else{
        $_SESSION['resultArray'] = array();
        $result = array();
        header("Location: ../html/report.php");
    }
    $conn->close();
}

function importCandidate() {
    
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "HR_DB";
    $port = 3306;
    
    $dateSourced = "";
    $firstName = "";
    $lastName = "";
    $employerName = "";
    $employerDate = "";
    $email = "";
    $linkedin = "";
    $notes = "";
    $role = "";
    $seniority = "";
    $gender = "";
    $school = "";
    $gradYear = "";
    $contacted = "";
    $contactedDate = "";
    $followup = "";
    $followupDate = "";
    
    $arrCandidates = array();
    $none = "";
        
    if(isset($_SESSION['arrCandidates'])){
        $arrCandidates = $_SESSION['arrCandidates'];
    }
    
    if (count($arrCandidates)>0){
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        echo "Connected successfully";

//        $sql = "CREATE DATABASE HR_DB";
//
//        $sql = "CREATE TABLE IF NOT EXISTS Candidates (
//            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//            dateSourced VARCHAR (30),
//            firstName VARCHAR(30),
//            lastName VARCHAR(30),
//            employerName VARCHAR (30),
//            employerDate VARCHAR (30),
//            email VARCHAR(100),
//            linkedin VARCHAR(200),
//            notes TEXT,
//            role VARCHAR (30),
//            seniority VARCHAR (30),
//            gender VARCHAR (30),
//            school VARCHAR (100),
//            gradYear VARCHAR (30),
//            contacted VARCHAR (30),
//            contactedDate VARCHAR (30),
//            followup VARCHAR (30),
//            followupDate VARCHAR (30),
//        )";
        
        for($i = 0; $i< count($arrCandidates); $i++){
            $candidate = array();
            $candidate = $arrCandidates[$i];
            if(count($candidate)>0){
                for($j = 0; $j<count($candidate); $j++){
                    if ($j==0 ? $dateSourced = $candidate[$j] : $none="");
                    if ($j==1 ? $firstName = $candidate[$j] : $none="");
                    if ($j==2 ? $lastName = $candidate[$j] : $none="");
                    if ($j==3 ? $employerName = $candidate[$j] : $none="");
                    if ($j==4 ? $employerDate = $candidate[$j] : $none="");
                    if ($j==5 ? $email = $candidate[$j] : $none="");
                    if ($j==6 ? $linkedin = $candidate[$j] : $none="");
                    if ($j==7 ? $notes = $candidate[$j] : $none="");
                    if ($j==8 ? $role = $candidate[$j] : $none="");
                    if ($j==9 ? $seniority = $candidate[$j] : $none="");
                    if ($j==10 ? $gender = $candidate[$j] : $none="");
                    if ($j==11 ? $school = $candidate[$j] : $none="");
                    if ($j==12 ? $gradYear = $candidate[$j] : $none="");
                    if ($j==13 ? $contacted = $candidate[$j] : $none="");
                    if ($j==14 ? $contactedDate = $candidate[$j] : $none="");
                    if ($j==15 ? $followup = $candidate[$j] : $none="");
                    if ($j==16 ? $followupDate = $candidate[$j] : $none="");
                }
                
                    if(strlen($dateSourced)>0){
                        $dateSourced = fixDate($dateSourced);
                    }

                    if(strlen($employerDate)>0){
                        $employerDate = fixDate($employerDate);
                    }

                    if(strlen($contactedDate)>0){
                        $contactedDate = fixDate($contactedDate);
                    }

                    if(strlen($followupDate)>0){
                        $followupDate = fixDate($followupDate);
                    }

                    $sql = "INSERT INTO Candidates (dateSourced, firstName, lastName, employerName, employerDate, email, linkedin, 
                    notes, role, seniority, gender, school, gradYear, contacted, contactedDate, followup, followupDate)
                    VALUES ('$dateSourced', '$firstName', '$lastName', '$employerName', '$employerDate', '$email', '$linkedin', 
                    '$notes', '$role', '$seniority', '$gender', '$school', '$gradYear', '$contacted', '$contactedDate', '$followup', '$followupDate')";

                    if ($conn->query($sql) === TRUE) {
                        header("Location: ../html/import.php?id=yes");
                    } else {
                        echo "Error creating table: " . $conn->error;
                    }
                    
            }
        }
        $conn->close();
    } 
}

function fixDate($dateStr){
    
        $dateToFix = strtotime($dateStr);
        $fixedDate = date("Y-m-d", $dateToFix);
        return $fixedDate;
}

function addStats() {
    
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "HR_DB";
    $port = 3306;

    $statsMonth = 0;
    $statsYear = 0;
    
    // Sales
    $salesReferralCandidates = "";
    $salesReferralPhone = "";
    $salesReferralOnsite = "";
    $salesReferralFinal = "";
    $salesReferralOffer = "";
    $salesReferralAccept = "";
    $salesReferralDecline = "";

    $salesAngelListCandidates = "";
    $salesAngelListPhone = "";
    $salesAngelListOnsite = "";
    $salesAngelListFinal = "";
    $salesAngelListOffer = "";
    $salesAngelListAccept = "";
    $salesAngelListDecline = "";
        
    $salesCareerSiteCandidates = "";
    $salesCareerSitePhone = "";
    $salesCareerSiteOnsite = "";
    $salesCareerSiteFinal = "";
    $salesCareerSiteOffer = "";
    $salesCareerSiteAccept = "";
    $salesCareerSiteDecline = "";
        
    $salesOutreachCandidates = "";
    $salesOutreachPhone = "";
    $salesOutreachOnsite = "";
    $salesOutreachFinal = "";
    $salesOutreachOffer = "";
    $salesOutreachAccept = "";
    $salesOutreachDecline = "";
    
    $salesHiredCandidates = "";
    $salesHiredPhone = "";
    $salesHiredOnsite = "";
    $salesHiredFinal = "";
    $salesHiredOffer = "";
    $salesHiredAccept = "";
    $salesHiredDecline = "";
    
    $salesGogohireCandidates = "";
    $salesGogohirePhone = "";
    $salesGogohireOnsite = "";
    $salesGogohireFinal = "";
    $salesGogohireOffer = "";
    $salesGogohireAccept = "";
    $salesGogohireDecline = "";
    
    $salesHireUpCandidates = "";
    $salesHireUpPhone = "";
    $salesHireUpOnsite = "";
    $salesHireUpFinal = "";
    $salesHireUpOffer = "";
    $salesHireUpAccept = "";
    $salesHireUpDecline = "";
    
    $salesConferencesCandidates = "";
    $salesConferencesPhone = "";
    $salesConferencesOnsite = "";
    $salesConferencesFinal = "";
    $salesConferencesOffer = "";
    $salesConferencesAccept = "";
    $salesConferencesDecline = "";
    
    //Engineering
    $engReferralCandidates = "";
    $engReferralPhone = "";
    $engReferralOnsite = "";
    $engReferralFinal = "";
    $engReferralOffer = "";
    $engReferralAccept = "";
    $engReferralDecline = "";

    $engAngelListCandidates = "";
    $engAngelListPhone = "";
    $engAngelListOnsite = "";
    $engAngelListFinal = "";
    $engAngelListOffer = "";
    $engAngelListAccept = "";
    $engAngelListDecline = "";
        
    $engCareerSiteCandidates = "";
    $engCareerSitePhone = "";
    $engCareerSiteOnsite = "";
    $engCareerSiteFinal = "";
    $engCareerSiteOffer = "";
    $engCareerSiteAccept = "";
    $engCareerSiteDecline = "";
        
    $engOutreachCandidates = "";
    $engOutreachPhone = "";
    $engOutreachOnsite = "";
    $engOutreachFinal = "";
    $engOutreachOffer = "";
    $engOutreachAccept = "";
    $engOutreachDecline = "";
    
    $engHiredCandidates = "";
    $engHiredPhone = "";
    $engHiredOnsite = "";
    $engHiredFinal = "";
    $engHiredOffer = "";
    $engHiredAccept = "";
    $engHiredDecline = "";
    
    $engGogohireCandidates = "";
    $engGogohirePhone = "";
    $engGogohireOnsite = "";
    $engGogohireFinal = "";
    $engGogohireOffer = "";
    $engGogohireAccept = "";
    $engGogohireDecline = "";
    
    $engHireUpCandidates = "";
    $engHireUpPhone = "";
    $engHireUpOnsite = "";
    $engHireUpFinal = "";
    $engHireUpOffer = "";
    $engHireUpAccept = "";
    $engHireUpDecline = "";
    
    $engConferencesCandidates = "";
    $engConferencesPhone = "";
    $engConferencesOnsite = "";
    $engConferencesFinal = "";
    $engConferencesOffer = "";
    $engConferencesAccept = "";
    $engConferencesDecline = "";
    
    //CSM
    $csmReferralCandidates = "";
    $csmReferralPhone = "";
    $csmReferralOnsite = "";
    $csmReferralFinal = "";
    $csmReferralOffer = "";
    $csmReferralAccept = "";
    $csmReferralDecline = "";

    $csmAngelListCandidates = "";
    $csmAngelListPhone = "";
    $csmAngelListOnsite = "";
    $csmAngelListFinal = "";
    $csmAngelListOffer = "";
    $csmAngelListAccept = "";
    $csmAngelListDecline = "";
        
    $csmCareerSiteCandidates = "";
    $csmCareerSitePhone = "";
    $csmCareerSiteOnsite = "";
    $csmCareerSiteFinal = "";
    $csmCareerSiteOffer = "";
    $csmCareerSiteAccept = "";
    $csmCareerSiteDecline = "";
        
    $csmOutreachCandidates = "";
    $csmOutreachPhone = "";
    $csmOutreachOnsite = "";
    $csmOutreachFinal = "";
    $csmOutreachOffer = "";
    $csmOutreachAccept = "";
    $csmOutreachDecline = "";
    
    $csmHiredCandidates = "";
    $csmHiredPhone = "";
    $csmHiredOnsite = "";
    $csmHiredFinal = "";
    $csmHiredOffer = "";
    $csmHiredAccept = "";
    $csmHiredDecline = "";
    
    $csmGogohireCandidates = "";
    $csmGogohirePhone = "";
    $csmGogohireOnsite = "";
    $csmGogohireFinal = "";
    $csmGogohireOffer = "";
    $csmGogohireAccept = "";
    $csmGogohireDecline = "";
    
    $csmHireUpCandidates = "";
    $csmHireUpPhone = "";
    $csmHireUpOnsite = "";
    $csmHireUpFinal = "";
    $csmHireUpOffer = "";
    $csmHireUpAccept = "";
    $csmHireUpDecline = "";
    
    $csmConferencesCandidates = "";
    $csmConferencesPhone = "";
    $csmConferencesOnsite = "";
    $csmConferencesFinal = "";
    $csmConferencesOffer = "";
    $csmConferencesAccept = "";
    $csmConferencesDecline = "";   

    //Interns
    $internsReferralCandidates = "";
    $internsReferralPhone = "";
    $internsReferralOnsite = "";
    $internsReferralFinal = "";
    $internsReferralOffer = "";
    $internsReferralAccept = "";
    $internsReferralDecline = "";

    $internsAngelListCandidates = "";
    $internsAngelListPhone = "";
    $internsAngelListOnsite = "";
    $internsAngelListFinal = "";
    $internsAngelListOffer = "";
    $internsAngelListAccept = "";
    $internsAngelListDecline = "";
        
    $internsCareerSiteCandidates = "";
    $internsCareerSitePhone = "";
    $internsCareerSiteOnsite = "";
    $internsCareerSiteFinal = "";
    $internsCareerSiteOffer = "";
    $internsCareerSiteAccept = "";
    $internsCareerSiteDecline = "";
        
    $internsOutreachCandidates = "";
    $internsOutreachPhone = "";
    $internsOutreachOnsite = "";
    $internsOutreachFinal = "";
    $internsOutreachOffer = "";
    $internsOutreachAccept = "";
    $internsOutreachDecline = "";
    
    $internsHiredCandidates = "";
    $internsHiredPhone = "";
    $internsHiredOnsite = "";
    $internsHiredFinal = "";
    $internsHiredOffer = "";
    $internsHiredAccept = "";
    $internsHiredDecline = "";
    
    $internsGogohireCandidates = "";
    $internsGogohirePhone = "";
    $internsGogohireOnsite = "";
    $internsGogohireFinal = "";
    $internsGogohireOffer = "";
    $internsGogohireAccept = "";
    $internsGogohireDecline = "";
    
    $internsHireUpCandidates = "";
    $internsHireUpPhone = "";
    $internsHireUpOnsite = "";
    $internsHireUpFinal = "";
    $internsHireUpOffer = "";
    $internsHireUpAccept = "";
    $internsHireUpDecline = "";
    
    $internsConferencesCandidates = "";
    $internsConferencesPhone = "";
    $internsConferencesOnsite = "";
    $internsConferencesFinal = "";
    $internsConferencesOffer = "";
    $internsConferencesAccept = "";
    $internsConferencesDecline = "";

    $none = "";

    $dom = new DOMDocument();
    $path = "/Applications/AMPPS/www/html/stats.php";
    $html = file_get_contents($path); 
    $dom->loadHTML($html);

    $input = $dom->getElementsByTagName('input');
    for($i=0; $i<$input->length; $i++){
        $name = $input->item($i)->getAttribute('name');
        // Sales
        if ($name == 'salesReferralCandidates' ? $salesReferralCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesReferralPhone' ? $salesReferralPhone = $_POST[$name] : $none = "");
        if ($name == 'salesReferralOnsite' ? $salesReferralOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesReferralFinal' ? $salesReferralFinal = $_POST[$name] : $none = "");
        if ($name == 'salesReferralOffer' ? $salesReferralOffer = $_POST[$name] : $none = "");
        if ($name == 'salesReferralAccept' ? $salesReferralAccept = $_POST[$name] : $none = "");
        if ($name == 'salesReferralDecline' ? $salesReferralDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesAngelListCandidates' ? $salesAngelListCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListPhone' ? $salesAngelListPhone = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListOnsite' ? $salesAngelListOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListFinal' ? $salesAngelListFinal = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListOffer' ? $salesAngelListOffer = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListAccept' ? $salesAngelListAccept = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListDecline' ? $salesAngelListDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesCareerSiteCandidates' ? $salesCareerSiteCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSitePhone' ? $salesCareerSitePhone = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSiteOnsite' ? $salesCareerSiteOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSiteFinal' ? $salesCareerSiteFinal = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSiteOffer' ? $salesCareerSiteOffer = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSiteAccept' ? $salesCareerSiteAccept = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSiteDecline' ? $salesCareerSiteDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesOutreachCandidates' ? $salesOutreachCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachPhone' ? $salesOutreachPhone = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachOnsite' ? $salesOutreachOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachFinal' ? $salesOutreachFinal = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachOffer' ? $salesOutreachOffer = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachAccept' ? $salesOutreachAccept = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachDecline' ? $salesOutreachDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesHiredCandidates' ? $salesHiredCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesHiredPhone' ? $salesHiredPhone = $_POST[$name] : $none = "");
        if ($name == 'salesHiredOnsite' ? $salesHiredOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesHiredFinal' ? $salesHiredFinal = $_POST[$name] : $none = "");
        if ($name == 'salesHiredOffer' ? $salesHiredOffer = $_POST[$name] : $none = "");
        if ($name == 'salesHiredAccept' ? $salesHiredAccept = $_POST[$name] : $none = "");
        if ($name == 'salesHiredDecline' ? $salesHiredDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesGogohireCandidates' ? $salesGogohireCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesGogohirePhone' ? $salesGogohirePhone = $_POST[$name] : $none = "");
        if ($name == 'salesGogohireOnsite' ? $salesGogohireOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesGogohireFinal' ? $salesGogohireFinal = $_POST[$name] : $none = "");
        if ($name == 'salesGogohireOffer' ? $salesGogohireOffer = $_POST[$name] : $none = "");
        if ($name == 'salesGogohireAccept' ? $salesGogohireAccept = $_POST[$name] : $none = "");
        if ($name == 'salesGogohireDecline' ? $salesGogohireDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesHireUpCandidates' ? $salesHireUpCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpPhone' ? $salesHireUpPhone = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpOnsite' ? $salesHireUpOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpFinal' ? $salesHireUpFinal = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpOffer' ? $salesHireUpOffer = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpAccept' ? $salesHireUpAccept = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpDecline' ? $salesHireUpDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesConferencesCandidates' ? $salesConferencesCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesPhone' ? $salesConferencesPhone = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesOnsite' ? $salesConferencesOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesFinal' ? $salesConferencesFinal = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesOffer' ? $salesConferencesOffer = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesAccept' ? $salesConferencesAccept = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesDecline' ? $salesConferencesDecline = $_POST[$name] : $none = "");
        
        //Engineering
        if ($name == 'engReferralCandidates' ? $engReferralCandidates = $_POST[$name] : $none = "");
        if ($name == 'engReferralPhone' ? $engReferralPhone = $_POST[$name] : $none = "");
        if ($name == 'engReferralOnsite' ? $engReferralOnsite = $_POST[$name] : $none = "");
        if ($name == 'engReferralFinal' ? $engReferralFinal = $_POST[$name] : $none = "");
        if ($name == 'engReferralOffer' ? $engReferralOffer = $_POST[$name] : $none = "");
        if ($name == 'engReferralAccept' ? $engReferralAccept = $_POST[$name] : $none = "");
        if ($name == 'engReferralDecline' ? $engReferralDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engAngelListCandidates' ? $engAngelListCandidates = $_POST[$name] : $none = "");
        if ($name == 'engAngelListPhone' ? $engAngelListPhone = $_POST[$name] : $none = "");
        if ($name == 'engAngelListOnsite' ? $engAngelListOnsite = $_POST[$name] : $none = "");
        if ($name == 'engAngelListFinal' ? $engAngelListFinal = $_POST[$name] : $none = "");
        if ($name == 'engAngelListOffer' ? $engAngelListOffer = $_POST[$name] : $none = "");
        if ($name == 'engAngelListAccept' ? $engAngelListAccept = $_POST[$name] : $none = "");
        if ($name == 'engAngelListDecline' ? $engAngelListDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engCareerSiteCandidates' ? $engCareerSiteCandidates = $_POST[$name] : $none = "");
        if ($name == 'engCareerSitePhone' ? $engCareerSitePhone = $_POST[$name] : $none = "");
        if ($name == 'engCareerSiteOnsite' ? $engCareerSiteOnsite = $_POST[$name] : $none = "");
        if ($name == 'engCareerSiteFinal' ? $engCareerSiteFinal = $_POST[$name] : $none = "");
        if ($name == 'engCareerSiteOffer' ? $engCareerSiteOffer = $_POST[$name] : $none = "");
        if ($name == 'engCareerSiteAccept' ? $engCareerSiteAccept = $_POST[$name] : $none = "");
        if ($name == 'engCareerSiteDecline' ? $engCareerSiteDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engOutreachCandidates' ? $engOutreachCandidates = $_POST[$name] : $none = "");
        if ($name == 'engOutreachPhone' ? $engOutreachPhone = $_POST[$name] : $none = "");
        if ($name == 'engOutreachOnsite' ? $engOutreachOnsite = $_POST[$name] : $none = "");
        if ($name == 'engOutreachFinal' ? $engOutreachFinal = $_POST[$name] : $none = "");
        if ($name == 'engOutreachOffer' ? $engOutreachOffer = $_POST[$name] : $none = "");
        if ($name == 'engOutreachAccept' ? $engOutreachAccept = $_POST[$name] : $none = "");
        if ($name == 'engOutreachDecline' ? $engOutreachDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engHiredCandidates' ? $engHiredCandidates = $_POST[$name] : $none = "");
        if ($name == 'engHiredPhone' ? $engHiredPhone = $_POST[$name] : $none = "");
        if ($name == 'engHiredOnsite' ? $engHiredOnsite = $_POST[$name] : $none = "");
        if ($name == 'engHiredFinal' ? $engHiredFinal = $_POST[$name] : $none = "");
        if ($name == 'engHiredOffer' ? $engHiredOffer = $_POST[$name] : $none = "");
        if ($name == 'engHiredAccept' ? $engHiredAccept = $_POST[$name] : $none = "");
        if ($name == 'engHiredDecline' ? $engHiredDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engGogohireCandidates' ? $engGogohireCandidates = $_POST[$name] : $none = "");
        if ($name == 'engGogohirePhone' ? $engGogohirePhone = $_POST[$name] : $none = "");
        if ($name == 'engGogohireOnsite' ? $engGogohireOnsite = $_POST[$name] : $none = "");
        if ($name == 'engGogohireFinal' ? $engGogohireFinal = $_POST[$name] : $none = "");
        if ($name == 'engGogohireOffer' ? $engGogohireOffer = $_POST[$name] : $none = "");
        if ($name == 'engGogohireAccept' ? $engGogohireAccept = $_POST[$name] : $none = "");
        if ($name == 'engGogohireDecline' ? $engGogohireDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engHireUpCandidates' ? $engHireUpCandidates = $_POST[$name] : $none = "");
        if ($name == 'engHireUpPhone' ? $engHireUpPhone = $_POST[$name] : $none = "");
        if ($name == 'engHireUpOnsite' ? $engHireUpOnsite = $_POST[$name] : $none = "");
        if ($name == 'engHireUpFinal' ? $engHireUpFinal = $_POST[$name] : $none = "");
        if ($name == 'engHireUpOffer' ? $engHireUpOffer = $_POST[$name] : $none = "");
        if ($name == 'engHireUpAccept' ? $engHireUpAccept = $_POST[$name] : $none = "");
        if ($name == 'engHireUpDecline' ? $engHireUpDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engConferencesCandidates' ? $engConferencesCandidates = $_POST[$name] : $none = "");
        if ($name == 'engConferencesPhone' ? $engConferencesPhone = $_POST[$name] : $none = "");
        if ($name == 'engConferencesOnsite' ? $engConferencesOnsite = $_POST[$name] : $none = "");
        if ($name == 'engConferencesFinal' ? $engConferencesFinal = $_POST[$name] : $none = "");
        if ($name == 'engConferencesOffer' ? $engConferencesOffer = $_POST[$name] : $none = "");
        if ($name == 'engConferencesAccept' ? $engConferencesAccept = $_POST[$name] : $none = "");
        if ($name == 'engConferencesDecline' ? $engConferencesDecline = $_POST[$name] : $none = "");
        
        //CSM
        if ($name == 'csmReferralCandidates' ? $csmReferralCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmReferralPhone' ? $csmReferralPhone = $_POST[$name] : $none = "");
        if ($name == 'csmReferralOnsite' ? $csmReferralOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmReferralFinal' ? $csmReferralFinal = $_POST[$name] : $none = "");
        if ($name == 'csmReferralOffer' ? $csmReferralOffer = $_POST[$name] : $none = "");
        if ($name == 'csmReferralAccept' ? $csmReferralAccept = $_POST[$name] : $none = "");
        if ($name == 'csmReferralDecline' ? $csmReferralDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmAngelListCandidates' ? $csmAngelListCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListPhone' ? $csmAngelListPhone = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListOnsite' ? $csmAngelListOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListFinal' ? $csmAngelListFinal = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListOffer' ? $csmAngelListOffer = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListAccept' ? $csmAngelListAccept = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListDecline' ? $csmAngelListDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmCareerSiteCandidates' ? $csmCareerSiteCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSitePhone' ? $csmCareerSitePhone = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSiteOnsite' ? $csmCareerSiteOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSiteFinal' ? $csmCareerSiteFinal = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSiteOffer' ? $csmCareerSiteOffer = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSiteAccept' ? $csmCareerSiteAccept = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSiteDecline' ? $csmCareerSiteDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmOutreachCandidates' ? $csmOutreachCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachPhone' ? $csmOutreachPhone = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachOnsite' ? $csmOutreachOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachFinal' ? $csmOutreachFinal = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachOffer' ? $csmOutreachOffer = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachAccept' ? $csmOutreachAccept = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachDecline' ? $csmOutreachDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmHiredCandidates' ? $csmHiredCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmHiredPhone' ? $csmHiredPhone = $_POST[$name] : $none = "");
        if ($name == 'csmHiredOnsite' ? $csmHiredOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmHiredFinal' ? $csmHiredFinal = $_POST[$name] : $none = "");
        if ($name == 'csmHiredOffer' ? $csmHiredOffer = $_POST[$name] : $none = "");
        if ($name == 'csmHiredAccept' ? $csmHiredAccept = $_POST[$name] : $none = "");
        if ($name == 'csmHiredDecline' ? $csmHiredDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmGogohireCandidates' ? $csmGogohireCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmGogohirePhone' ? $csmGogohirePhone = $_POST[$name] : $none = "");
        if ($name == 'csmGogohireOnsite' ? $csmGogohireOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmGogohireFinal' ? $csmGogohireFinal = $_POST[$name] : $none = "");
        if ($name == 'csmGogohireOffer' ? $csmGogohireOffer = $_POST[$name] : $none = "");
        if ($name == 'csmGogohireAccept' ? $csmGogohireAccept = $_POST[$name] : $none = "");
        if ($name == 'csmGogohireDecline' ? $csmGogohireDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmHireUpCandidates' ? $csmHireUpCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpPhone' ? $csmHireUpPhone = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpOnsite' ? $csmHireUpOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpFinal' ? $csmHireUpFinal = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpOffer' ? $csmHireUpOffer = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpAccept' ? $csmHireUpAccept = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpDecline' ? $csmHireUpDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmConferencesCandidates' ? $csmConferencesCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesPhone' ? $csmConferencesPhone = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesOnsite' ? $csmConferencesOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesFinal' ? $csmConferencesFinal = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesOffer' ? $csmConferencesOffer = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesAccept' ? $csmConferencesAccept = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesDecline' ? $csmConferencesDecline = $_POST[$name] : $none = "");
        
        //Interns
        if ($name == 'internsReferralCandidates' ? $internsReferralCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsReferralPhone' ? $internsReferralPhone = $_POST[$name] : $none = "");
        if ($name == 'internsReferralOnsite' ? $internsReferralOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsReferralFinal' ? $internsReferralFinal = $_POST[$name] : $none = "");
        if ($name == 'internsReferralOffer' ? $internsReferralOffer = $_POST[$name] : $none = "");
        if ($name == 'internsReferralAccept' ? $internsReferralAccept = $_POST[$name] : $none = "");
        if ($name == 'internsReferralDecline' ? $internsReferralDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsAngelListCandidates' ? $internsAngelListCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListPhone' ? $internsAngelListPhone = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListOnsite' ? $internsAngelListOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListFinal' ? $internsAngelListFinal = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListOffer' ? $internsAngelListOffer = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListAccept' ? $internsAngelListAccept = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListDecline' ? $internsAngelListDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsCareerSiteCandidates' ? $internsCareerSiteCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSitePhone' ? $internsCareerSitePhone = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSiteOnsite' ? $internsCareerSiteOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSiteFinal' ? $internsCareerSiteFinal = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSiteOffer' ? $internsCareerSiteOffer = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSiteAccept' ? $internsCareerSiteAccept = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSiteDecline' ? $internsCareerSiteDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsOutreachCandidates' ? $internsOutreachCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachPhone' ? $internsOutreachPhone = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachOnsite' ? $internsOutreachOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachFinal' ? $internsOutreachFinal = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachOffer' ? $internsOutreachOffer = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachAccept' ? $internsOutreachAccept = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachDecline' ? $internsOutreachDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsHiredCandidates' ? $internsHiredCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsHiredPhone' ? $internsHiredPhone = $_POST[$name] : $none = "");
        if ($name == 'internsHiredOnsite' ? $internsHiredOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsHiredFinal' ? $internsHiredFinal = $_POST[$name] : $none = "");
        if ($name == 'internsHiredOffer' ? $internsHiredOffer = $_POST[$name] : $none = "");
        if ($name == 'internsHiredAccept' ? $internsHiredAccept = $_POST[$name] : $none = "");
        if ($name == 'internsHiredDecline' ? $internsHiredDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsGogohireCandidates' ? $internsGogohireCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsGogohirePhone' ? $internsGogohirePhone = $_POST[$name] : $none = "");
        if ($name == 'internsGogohireOnsite' ? $internsGogohireOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsGogohireFinal' ? $internsGogohireFinal = $_POST[$name] : $none = "");
        if ($name == 'internsGogohireOffer' ? $internsGogohireOffer = $_POST[$name] : $none = "");
        if ($name == 'internsGogohireAccept' ? $internsGogohireAccept = $_POST[$name] : $none = "");
        if ($name == 'internsGogohireDecline' ? $internsGogohireDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsHireUpCandidates' ? $internsHireUpCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpPhone' ? $internsHireUpPhone = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpOnsite' ? $internsHireUpOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpFinal' ? $internsHireUpFinal = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpOffer' ? $internsHireUpOffer = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpAccept' ? $internsHireUpAccept = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpDecline' ? $internsHireUpDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsConferencesCandidates' ? $internsConferencesCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesPhone' ? $internsConferencesPhone = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesOnsite' ? $internsConferencesOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesFinal' ? $internsConferencesFinal = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesOffer' ? $internsConferencesOffer = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesAccept' ? $internsConferencesAccept = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesDecline' ? $internsConferencesDecline = $_POST[$name] : $none = "");
    }

    $select = $dom->getElementsByTagName('select');
    for($i=0; $i<$select->length; $i++){
        $name = $select->item($i)->getAttribute('name');

        if ($name == 'statsMonth' ? $statsMonth = $_POST[$name] : $none = "");
        if ($name == 'statsYear' ? $statsYear = $_POST[$name] : $none = "");
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";

    $sql = "CREATE DATABASE HR_DB";

    $sql = "CREATE TABLE IF NOT EXISTS Stats (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        statsMonth INTEGER,
        statsYear INTEGER,
        salesReferralCandidates INTEGER,
        salesReferralPhone INTEGER,
        salesReferralOnsite INTEGER,
        salesReferralFinal INTEGER,
        salesReferralOffer INTEGER,
        salesReferralAccept INTEGER,
        salesReferralDecline INTEGER,
        salesAngelListCandidates INTEGER,
        salesAngelListPhone INTEGER,
        salesAngelListOnsite INTEGER,
        salesAngelListFinal INTEGER,
        salesAngelListOffer INTEGER,
        salesAngelListAccept INTEGER,
        salesAngelListDecline INTEGER,
        salesCareerSiteCandidates INTEGER,
        salesCareerSitePhone INTEGER,
        salesCareerSiteOnsite INTEGER,
        salesCareerSiteFinal INTEGER,
        salesCareerSiteOffer INTEGER,
        salesCareerSiteAccept INTEGER,
        salesCareerSiteDecline INTEGER,
        salesOutreachCandidates INTEGER,
        salesOutreachPhone INTEGER,
        salesOutreachOnsite INTEGER,
        salesOutreachFinal INTEGER,
        salesOutreachOffer INTEGER,
        salesOutreachAccept INTEGER,
        salesOutreachDecline INTEGER,
        salesHiredCandidates INTEGER,
        salesHiredPhone INTEGER,
        salesHiredOnsite INTEGER,
        salesHiredFinal INTEGER,
        salesHiredOffer INTEGER,
        salesHiredAccept INTEGER,
        salesHiredDecline INTEGER,
        salesGogohireCandidates INTEGER,
        salesGogohirePhone INTEGER,
        salesGogohireOnsite INTEGER,
        salesGogohireFinal INTEGER,
        salesGogohireOffer INTEGER,
        salesGogohireAccept INTEGER,
        salesGogohireDecline INTEGER,
        salesHireUpCandidates INTEGER,
        salesHireUpPhone INTEGER,
        salesHireUpOnsite INTEGER,
        salesHireUpFinal INTEGER,
        salesHireUpOffer INTEGER,
        salesHireUpAccept INTEGER,
        salesHireUpDecline INTEGER,
        salesConferencesCandidates INTEGER,
        salesConferencesPhone INTEGER,
        salesConferencesOnsite INTEGER,
        salesConferencesFinal INTEGER,
        salesConferencesOffer INTEGER,
        salesConferencesAccept INTEGER,
        salesConferencesDecline INTEGER,
        engReferralCandidates INTEGER,
        engReferralPhone INTEGER,
        engReferralOnsite INTEGER,
        engReferralFinal INTEGER,
        engReferralOffer INTEGER,
        engReferralAccept INTEGER,
        engReferralDecline INTEGER,
        engAngelListCandidates INTEGER,
        engAngelListPhone INTEGER,
        engAngelListOnsite INTEGER,
        engAngelListFinal INTEGER,
        engAngelListOffer INTEGER,
        engAngelListAccept INTEGER,
        engAngelListDecline INTEGER,
        engCareerSiteCandidates INTEGER,
        engCareerSitePhone INTEGER,
        engCareerSiteOnsite INTEGER,
        engCareerSiteFinal INTEGER,
        engCareerSiteOffer INTEGER,
        engCareerSiteAccept INTEGER,
        engCareerSiteDecline INTEGER,
        engOutreachCandidates INTEGER,
        engOutreachPhone INTEGER,
        engOutreachOnsite INTEGER,
        engOutreachFinal INTEGER,
        engOutreachOffer INTEGER,
        engOutreachAccept INTEGER,
        engOutreachDecline INTEGER,
        engHiredCandidates INTEGER,
        engHiredPhone INTEGER,
        engHiredOnsite INTEGER,
        engHiredFinal INTEGER,
        engHiredOffer INTEGER,
        engHiredAccept INTEGER,
        engHiredDecline INTEGER,
        engGogohireCandidates INTEGER,
        engGogohirePhone INTEGER,
        engGogohireOnsite INTEGER,
        engGogohireFinal INTEGER,
        engGogohireOffer INTEGER,
        engGogohireAccept INTEGER,
        engGogohireDecline INTEGER,
        engHireUpCandidates INTEGER,
        engHireUpPhone INTEGER,
        engHireUpOnsite INTEGER,
        engHireUpFinal INTEGER,
        engHireUpOffer INTEGER,
        engHireUpAccept INTEGER,
        engHireUpDecline INTEGER,
        engConferencesCandidates INTEGER,
        engConferencesPhone INTEGER,
        engConferencesOnsite INTEGER,
        engConferencesFinal INTEGER,
        engConferencesOffer INTEGER,
        engConferencesAccept INTEGER,
        engConferencesDecline INTEGER,
        csmReferralCandidates INTEGER,
        csmReferralPhone INTEGER,
        csmReferralOnsite INTEGER,
        csmReferralFinal INTEGER,
        csmReferralOffer INTEGER,
        csmReferralAccept INTEGER,
        csmReferralDecline INTEGER,
        csmAngelListCandidates INTEGER,
        csmAngelListPhone INTEGER,
        csmAngelListOnsite INTEGER,
        csmAngelListFinal INTEGER,
        csmAngelListOffer INTEGER,
        csmAngelListAccept INTEGER,
        csmAngelListDecline INTEGER,
        csmCareerSiteCandidates INTEGER,
        csmCareerSitePhone INTEGER,
        csmCareerSiteOnsite INTEGER,
        csmCareerSiteFinal INTEGER,
        csmCareerSiteOffer INTEGER,
        csmCareerSiteAccept INTEGER,
        csmCareerSiteDecline INTEGER,
        csmOutreachCandidates INTEGER,
        csmOutreachPhone INTEGER,
        csmOutreachOnsite INTEGER,
        csmOutreachFinal INTEGER,
        csmOutreachOffer INTEGER,
        csmOutreachAccept INTEGER,
        csmOutreachDecline INTEGER,
        csmHiredCandidates INTEGER,
        csmHiredPhone INTEGER,
        csmHiredOnsite INTEGER,
        csmHiredFinal INTEGER,
        csmHiredOffer INTEGER,
        csmHiredAccept INTEGER,
        csmHiredDecline INTEGER,
        csmGogohireCandidates INTEGER,
        csmGogohirePhone INTEGER,
        csmGogohireOnsite INTEGER,
        csmGogohireFinal INTEGER,
        csmGogohireOffer INTEGER,
        csmGogohireAccept INTEGER,
        csmGogohireDecline INTEGER,
        csmHireUpCandidates INTEGER,
        csmHireUpPhone INTEGER,
        csmHireUpOnsite INTEGER,
        csmHireUpFinal INTEGER,
        csmHireUpOffer INTEGER,
        csmHireUpAccept INTEGER,
        csmHireUpDecline INTEGER,
        csmConferencesCandidates INTEGER,
        csmConferencesPhone INTEGER,
        csmConferencesOnsite INTEGER,
        csmConferencesFinal INTEGER,
        csmConferencesOffer INTEGER,
        csmConferencesAccept INTEGER,
        csmConferencesDecline INTEGER,
        internsReferralCandidates INTEGER,
        internsReferralPhone INTEGER,
        internsReferralOnsite INTEGER,
        internsReferralFinal INTEGER,
        internsReferralOffer INTEGER,
        internsReferralAccept INTEGER,
        internsReferralDecline INTEGER,
        internsAngelListCandidates INTEGER,
        internsAngelListPhone INTEGER,
        internsAngelListOnsite INTEGER,
        internsAngelListFinal INTEGER,
        internsAngelListOffer INTEGER,
        internsAngelListAccept INTEGER,
        internsAngelListDecline INTEGER,
        internsCareerSiteCandidates INTEGER,
        internsCareerSitePhone INTEGER,
        internsCareerSiteOnsite INTEGER,
        internsCareerSiteFinal INTEGER,
        internsCareerSiteOffer INTEGER,
        internsCareerSiteAccept INTEGER,
        internsCareerSiteDecline INTEGER,
        internsOutreachCandidates INTEGER,
        internsOutreachPhone INTEGER,
        internsOutreachOnsite INTEGER,
        internsOutreachFinal INTEGER,
        internsOutreachOffer INTEGER,
        internsOutreachAccept INTEGER,
        internsOutreachDecline INTEGER,
        internsHiredCandidates INTEGER,
        internsHiredPhone INTEGER,
        internsHiredOnsite INTEGER,
        internsHiredFinal INTEGER,
        internsHiredOffer INTEGER,
        internsHiredAccept INTEGER,
        internsHiredDecline INTEGER,
        internsGogohireCandidates INTEGER,
        internsGogohirePhone INTEGER,
        internsGogohireOnsite INTEGER,
        internsGogohireFinal INTEGER,
        internsGogohireOffer INTEGER,
        internsGogohireAccept INTEGER,
        internsGogohireDecline INTEGER,
        internsHireUpCandidates INTEGER,
        internsHireUpPhone INTEGER,
        internsHireUpOnsite INTEGER,
        internsHireUpFinal INTEGER,
        internsHireUpOffer INTEGER,
        internsHireUpAccept INTEGER,
        internsHireUpDecline INTEGER,
        internsConferencesCandidates INTEGER,
        internsConferencesPhone INTEGER,
        internsConferencesOnsite INTEGER,
        internsConferencesFinal INTEGER,
        internsConferencesOffer INTEGER,
        internsConferencesAccept INTEGER,
        internsConferencesDecline INTEGER    
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    
    $sql = "INSERT INTO Stats (statsMonth, statsYear, salesReferralCandidates, salesReferralPhone, salesReferralOnsite, salesReferralFinal, salesReferralOffer, salesReferralAccept, salesReferralDecline, salesAngelListCandidates, salesAngelListPhone, salesAngelListOnsite, salesAngelListFinal, salesAngelListOffer, salesAngelListAccept,salesAngelListDecline, salesCareerSiteCandidates, salesCareerSitePhone, salesCareerSiteOnsite, salesCareerSiteFinal, salesCareerSiteOffer, salesCareerSiteAccept, salesCareerSiteDecline, salesOutreachCandidates, salesOutreachPhone, salesOutreachOnsite, salesOutreachFinal, salesOutreachOffer, salesOutreachAccept, salesOutreachDecline, salesHiredCandidates, salesHiredPhone, salesHiredOnsite, salesHiredFinal, salesHiredOffer, salesHiredAccept, salesHiredDecline, salesGogohireCandidates, salesGogohirePhone, salesGogohireOnsite, salesGogohireFinal, salesGogohireOffer, salesGogohireAccept, salesGogohireDecline, salesHireUpCandidates, salesHireUpPhone, salesHireUpOnsite, salesHireUpFinal, salesHireUpOffer, salesHireUpAccept, salesHireUpDecline, salesConferencesCandidates, salesConferencesPhone, salesConferencesOnsite, salesConferencesFinal, salesConferencesOffer, salesConferencesAccept, salesConferencesDecline, engReferralCandidates, engReferralPhone, engReferralOnsite, engReferralFinal, engReferralOffer, engReferralAccept, engReferralDecline, engAngelListCandidates, engAngelListPhone, engAngelListOnsite, engAngelListFinal, engAngelListOffer, engAngelListAccept, engAngelListDecline, engCareerSiteCandidates, engCareerSitePhone, engCareerSiteOnsite, engCareerSiteFinal, engCareerSiteOffer, engCareerSiteAccept, engCareerSiteDecline, engOutreachCandidates, engOutreachPhone, engOutreachOnsite, engOutreachFinal, engOutreachOffer, engOutreachAccept, engOutreachDecline, engHiredCandidates, engHiredPhone, engHiredOnsite, engHiredFinal, engHiredOffer, engHiredAccept, engHiredDecline, engGogohireCandidates, engGogohirePhone, engGogohireOnsite, engGogohireFinal, engGogohireOffer, engGogohireAccept, engGogohireDecline, engHireUpCandidates, engHireUpPhone, engHireUpOnsite, engHireUpFinal, engHireUpOffer, engHireUpAccept, engHireUpDecline, engConferencesCandidates, engConferencesPhone, engConferencesOnsite, engConferencesFinal, engConferencesOffer, engConferencesAccept, engConferencesDecline, csmReferralCandidates, csmReferralPhone, csmReferralOnsite, csmReferralFinal, csmReferralOffer, csmReferralAccept, csmReferralDecline, csmAngelListCandidates, csmAngelListPhone, csmAngelListOnsite, csmAngelListFinal, csmAngelListOffer, csmAngelListAccept, csmAngelListDecline, csmCareerSiteCandidates, csmCareerSitePhone, csmCareerSiteOnsite, csmCareerSiteFinal, csmCareerSiteOffer,csmCareerSiteAccept, csmCareerSiteDecline, csmOutreachCandidates, csmOutreachPhone, csmOutreachOnsite, csmOutreachFinal, csmOutreachOffer, csmOutreachAccept, csmOutreachDecline, csmHiredCandidates, csmHiredPhone, csmHiredOnsite, csmHiredFinal, csmHiredOffer, csmHiredAccept, csmHiredDecline, csmGogohireCandidates, csmGogohirePhone, csmGogohireOnsite, csmGogohireFinal, csmGogohireOffer, csmGogohireAccept, csmGogohireDecline, csmHireUpCandidates, csmHireUpPhone, csmHireUpOnsite, csmHireUpFinal, csmHireUpOffer, csmHireUpAccept, csmHireUpDecline, csmConferencesCandidates, csmConferencesPhone, csmConferencesOnsite, csmConferencesFinal, csmConferencesOffer, csmConferencesAccept, csmConferencesDecline, internsReferralCandidates, internsReferralPhone,internsReferralOnsite, internsReferralFinal, internsReferralOffer, internsReferralAccept,  internsReferralDecline, internsAngelListCandidates, internsAngelListPhone, internsAngelListOnsite, internsAngelListFinal, internsAngelListOffer, internsAngelListAccept, internsAngelListDecline, internsCareerSiteCandidates, internsCareerSitePhone, internsCareerSiteOnsite, internsCareerSiteFinal, internsCareerSiteOffer, internsCareerSiteAccept, internsCareerSiteDecline, internsOutreachCandidates, internsOutreachPhone, internsOutreachOnsite, internsOutreachFinal, internsOutreachOffer, internsOutreachAccept, internsOutreachDecline, internsHiredCandidates, internsHiredPhone, internsHiredOnsite, internsHiredFinal, internsHiredOffer, internsHiredAccept, internsHiredDecline, internsGogohireCandidates, internsGogohirePhone, internsGogohireOnsite, internsGogohireFinal, internsGogohireOffer, internsGogohireAccept, internsGogohireDecline, internsHireUpCandidates, internsHireUpPhone, internsHireUpOnsite, internsHireUpFinal, internsHireUpOffer,internsHireUpAccept, internsHireUpDecline, internsConferencesCandidates, internsConferencesPhone, internsConferencesOnsite, internsConferencesFinal, internsConferencesOffer, internsConferencesAccept, internsConferencesDecline) VALUES ('$statsMonth', '$statsYear', '$salesReferralCandidates', '$salesReferralPhone', '$salesReferralOnsite', '$salesReferralFinal', '$salesReferralOffer', '$salesReferralAccept', '$salesReferralDecline', '$salesAngelListCandidates', '$salesAngelListPhone', '$salesAngelListOnsite', '$salesAngelListFinal', '$salesAngelListOffer', '$salesAngelListAccept','$salesAngelListDecline', '$salesCareerSiteCandidates', '$salesCareerSitePhone', '$salesCareerSiteOnsite', '$salesCareerSiteFinal', '$salesCareerSiteOffer', '$salesCareerSiteAccept', '$salesCareerSiteDecline', '$salesOutreachCandidates', '$salesOutreachPhone', '$salesOutreachOnsite', '$salesOutreachFinal', '$salesOutreachOffer', '$salesOutreachAccept', '$salesOutreachDecline', '$salesHiredCandidates', '$salesHiredPhone', '$salesHiredOnsite', '$salesHiredFinal', '$salesHiredOffer', '$salesHiredAccept', '$salesHiredDecline', '$salesGogohireCandidates', '$salesGogohirePhone', '$salesGogohireOnsite', '$salesGogohireFinal', '$salesGogohireOffer', '$salesGogohireAccept', '$salesGogohireDecline', '$salesHireUpCandidates', '$salesHireUpPhone', '$salesHireUpOnsite', '$salesHireUpFinal', '$salesHireUpOffer', '$salesHireUpAccept', '$salesHireUpDecline', '$salesConferencesCandidates', '$salesConferencesPhone', '$salesConferencesOnsite', '$salesConferencesFinal', '$salesConferencesOffer', '$salesConferencesAccept', '$salesConferencesDecline', '$engReferralCandidates', '$engReferralPhone', '$engReferralOnsite', '$engReferralFinal', '$engReferralOffer', '$engReferralAccept', '$engReferralDecline', '$engAngelListCandidates', '$engAngelListPhone', '$engAngelListOnsite', '$engAngelListFinal', '$engAngelListOffer', '$engAngelListAccept', '$engAngelListDecline', '$engCareerSiteCandidates', '$engCareerSitePhone', '$engCareerSiteOnsite', '$engCareerSiteFinal', '$engCareerSiteOffer', '$engCareerSiteAccept', '$engCareerSiteDecline', '$engOutreachCandidates', '$engOutreachPhone', '$engOutreachOnsite', '$engOutreachFinal', '$engOutreachOffer', '$engOutreachAccept', '$engOutreachDecline', '$engHiredCandidates', '$engHiredPhone', '$engHiredOnsite', '$engHiredFinal', '$engHiredOffer','$engHiredAccept', '$engHiredDecline', '$engGogohireCandidates', '$engGogohirePhone', '$engGogohireOnsite', '$engGogohireFinal', '$engGogohireOffer', '$engGogohireAccept', '$engGogohireDecline', '$engHireUpCandidates', '$engHireUpPhone', '$engHireUpOnsite', '$engHireUpFinal', '$engHireUpOffer', '$engHireUpAccept', '$engHireUpDecline', '$engConferencesCandidates', '$engConferencesPhone', '$engConferencesOnsite', '$engConferencesFinal', '$engConferencesOffer', '$engConferencesAccept', '$engConferencesDecline', '$csmReferralCandidates', '$csmReferralPhone', '$csmReferralOnsite', '$csmReferralFinal', '$csmReferralOffer', '$csmReferralAccept', '$csmReferralDecline', '$csmAngelListCandidates', '$csmAngelListPhone', '$csmAngelListOnsite', '$csmAngelListFinal', '$csmAngelListOffer', '$csmAngelListAccept', '$csmAngelListDecline', '$csmCareerSiteCandidates', '$csmCareerSitePhone', '$csmCareerSiteOnsite', '$csmCareerSiteFinal', '$csmCareerSiteOffer','$csmCareerSiteAccept', '$csmCareerSiteDecline', '$csmOutreachCandidates', '$csmOutreachPhone', '$csmOutreachOnsite', '$csmOutreachFinal', '$csmOutreachOffer', '$csmOutreachAccept', '$csmOutreachDecline', '$csmHiredCandidates', '$csmHiredPhone', '$csmHiredOnsite', '$csmHiredFinal', '$csmHiredOffer', '$csmHiredAccept', '$csmHiredDecline', '$csmGogohireCandidates', '$csmGogohirePhone', '$csmGogohireOnsite', '$csmGogohireFinal', '$csmGogohireOffer', '$csmGogohireAccept', '$csmGogohireDecline', '$csmHireUpCandidates', '$csmHireUpPhone', '$csmHireUpOnsite', '$csmHireUpFinal', '$csmHireUpOffer', '$csmHireUpAccept', '$csmHireUpDecline', '$csmConferencesCandidates', '$csmConferencesPhone', '$csmConferencesOnsite', '$csmConferencesFinal', '$csmConferencesOffer', '$csmConferencesAccept', '$csmConferencesDecline', '$internsReferralCandidates', '$internsReferralPhone','$internsReferralOnsite', '$internsReferralFinal', '$internsReferralOffer', '$internsReferralAccept', '$internsReferralDecline', '$internsAngelListCandidates', '$internsAngelListPhone', '$internsAngelListOnsite', '$internsAngelListFinal', '$internsAngelListOffer', '$internsAngelListAccept', '$internsAngelListDecline', '$internsCareerSiteCandidates', '$internsCareerSitePhone', '$internsCareerSiteOnsite', '$internsCareerSiteFinal', '$internsCareerSiteOffer', '$internsCareerSiteAccept', '$internsCareerSiteDecline', '$internsOutreachCandidates', '$internsOutreachPhone', '$internsOutreachOnsite', '$internsOutreachFinal', '$internsOutreachOffer', '$internsOutreachAccept', '$internsOutreachDecline', '$internsHiredCandidates', '$internsHiredPhone', '$internsHiredOnsite', '$internsHiredFinal', '$internsHiredOffer', '$internsHiredAccept', '$internsHiredDecline', '$internsGogohireCandidates', '$internsGogohirePhone', '$internsGogohireOnsite', '$internsGogohireFinal', '$internsGogohireOffer', '$internsGogohireAccept', '$internsGogohireDecline', '$internsHireUpCandidates', '$internsHireUpPhone', '$internsHireUpOnsite', '$internsHireUpFinal', '$internsHireUpOffer','$internsHireUpAccept', '$internsHireUpDecline', '$internsConferencesCandidates', '$internsConferencesPhone', '$internsConferencesOnsite', '$internsConferencesFinal', '$internsConferencesOffer', '$internsConferencesAccept', '$internsConferencesDecline')";

    if(!isset($statsMonth) || !isset($statsYear)){
        header("Location: ../html/stats.php?id=invalidDate");
         $sql = "";
    }
    
    if($statsMonth == 0 || $statsYear == 0){
        header("Location: ../html/stats.php?id=invalidDate");
        $sql = "";
    }
    
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
        header("Location: ../html/stats.php?id=yes");
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $conn->close();
    
}

function editStats() {
    
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "HR_DB";
    $port = 3306;

    $statsMonth = 0;
    $statsYear = 0;
    

    $none = "";

    $dom = new DOMDocument();
    $path = "/Applications/AMPPS/www/html/editStats.php";
    $html = file_get_contents($path); 
    $dom->loadHTML($html);

    $select = $dom->getElementsByTagName('select');
    for($i=0; $i<$select->length; $i++){
        $name = $select->item($i)->getAttribute('name');

        if ($name == 'statsMonth' ? $statsMonth = intval( $_POST[$name]) : $none = "");
        if ($name == 'statsYear' ? $statsYear = intval( $_POST[$name]): $none = "");
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";
    
    if(!isset($statsMonth) || !isset($statsYear)){
        header("Location: ../html/editStats.php?id=invalidDate");
    }
    
    if($statsMonth == 0 || $statsYear == 0){
        header("Location: ../html/editStats.php?id=invalidDate");
    }

    $whereStr = "";
    
    $whereStr = "statsMonth='$statsMonth' AND statsYear='$statsYear'";
    $sql = "SELECT * FROM Stats WHERE ".$whereStr;
    
    $result = $conn->query($sql);
    
    $resultArray = array();
    
    while($row = mysqli_fetch_array($result)) {
        array_push($resultArray, $row);
    }
    
    if(isset($resultArray) && count($resultArray)>0){
        $_SESSION['resultArray'] = $resultArray;
         header("Location: ../html/editStats.php?id=no&month=".$statsMonth."&year=".$statsYear);
    } else {
        echo "Query error!";
        echo $sql;
    }
    
    $conn->close();
}

function updateStats() {
    
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "HR_DB";
    $port = 3306;

    $statsMonth = 0;
    $statsYear = 0;
    
    //    Sales
    $salesReferralCandidates = "";
    $salesReferralPhone = "";
    $salesReferralOnsite = "";
    $salesReferralFinal = "";
    $salesReferralOffer = "";
    $salesReferralAccept = "";
    $salesReferralDecline = "";

    $salesAngelListCandidates = "";
    $salesAngelListPhone = "";
    $salesAngelListOnsite = "";
    $salesAngelListFinal = "";
    $salesAngelListOffer = "";
    $salesAngelListAccept = "";
    $salesAngelListDecline = "";
        
    $salesCareerSiteCandidates = "";
    $salesCareerSitePhone = "";
    $salesCareerSiteOnsite = "";
    $salesCareerSiteFinal = "";
    $salesCareerSiteOffer = "";
    $salesCareerSiteAccept = "";
    $salesCareerSiteDecline = "";
        
    $salesOutreachCandidates = "";
    $salesOutreachPhone = "";
    $salesOutreachOnsite = "";
    $salesOutreachFinal = "";
    $salesOutreachOffer = "";
    $salesOutreachAccept = "";
    $salesOutreachDecline = "";
    
    $salesHiredCandidates = "";
    $salesHiredPhone = "";
    $salesHiredOnsite = "";
    $salesHiredFinal = "";
    $salesHiredOffer = "";
    $salesHiredAccept = "";
    $salesHiredDecline = "";
    
    $salesGogohireCandidates = "";
    $salesGogohirePhone = "";
    $salesGogohireOnsite = "";
    $salesGogohireFinal = "";
    $salesGogohireOffer = "";
    $salesGogohireAccept = "";
    $salesGogohireDecline = "";
    
    $salesHireUpCandidates = "";
    $salesHireUpPhone = "";
    $salesHireUpOnsite = "";
    $salesHireUpFinal = "";
    $salesHireUpOffer = "";
    $salesHireUpAccept = "";
    $salesHireUpDecline = "";
    
    $salesConferencesCandidates = "";
    $salesConferencesPhone = "";
    $salesConferencesOnsite = "";
    $salesConferencesFinal = "";
    $salesConferencesOffer = "";
    $salesConferencesAccept = "";
    $salesConferencesDecline = "";
    
    //Engineering
    $engReferralCandidates = "";
    $engReferralPhone = "";
    $engReferralOnsite = "";
    $engReferralFinal = "";
    $engReferralOffer = "";
    $engReferralAccept = "";
    $engReferralDecline = "";

    $engAngelListCandidates = "";
    $engAngelListPhone = "";
    $engAngelListOnsite = "";
    $engAngelListFinal = "";
    $engAngelListOffer = "";
    $engAngelListAccept = "";
    $engAngelListDecline = "";
        
    $engCareerSiteCandidates = "";
    $engCareerSitePhone = "";
    $engCareerSiteOnsite = "";
    $engCareerSiteFinal = "";
    $engCareerSiteOffer = "";
    $engCareerSiteAccept = "";
    $engCareerSiteDecline = "";
        
    $engOutreachCandidates = "";
    $engOutreachPhone = "";
    $engOutreachOnsite = "";
    $engOutreachFinal = "";
    $engOutreachOffer = "";
    $engOutreachAccept = "";
    $engOutreachDecline = "";
    
    $engHiredCandidates = "";
    $engHiredPhone = "";
    $engHiredOnsite = "";
    $engHiredFinal = "";
    $engHiredOffer = "";
    $engHiredAccept = "";
    $engHiredDecline = "";
    
    $engGogohireCandidates = "";
    $engGogohirePhone = "";
    $engGogohireOnsite = "";
    $engGogohireFinal = "";
    $engGogohireOffer = "";
    $engGogohireAccept = "";
    $engGogohireDecline = "";
    
    $engHireUpCandidates = "";
    $engHireUpPhone = "";
    $engHireUpOnsite = "";
    $engHireUpFinal = "";
    $engHireUpOffer = "";
    $engHireUpAccept = "";
    $engHireUpDecline = "";
    
    $engConferencesCandidates = "";
    $engConferencesPhone = "";
    $engConferencesOnsite = "";
    $engConferencesFinal = "";
    $engConferencesOffer = "";
    $engConferencesAccept = "";
    $engConferencesDecline = "";
    
    //CSM
    $csmReferralCandidates = "";
    $csmReferralPhone = "";
    $csmReferralOnsite = "";
    $csmReferralFinal = "";
    $csmReferralOffer = "";
    $csmReferralAccept = "";
    $csmReferralDecline = "";

    $csmAngelListCandidates = "";
    $csmAngelListPhone = "";
    $csmAngelListOnsite = "";
    $csmAngelListFinal = "";
    $csmAngelListOffer = "";
    $csmAngelListAccept = "";
    $csmAngelListDecline = "";
        
    $csmCareerSiteCandidates = "";
    $csmCareerSitePhone = "";
    $csmCareerSiteOnsite = "";
    $csmCareerSiteFinal = "";
    $csmCareerSiteOffer = "";
    $csmCareerSiteAccept = "";
    $csmCareerSiteDecline = "";
        
    $csmOutreachCandidates = "";
    $csmOutreachPhone = "";
    $csmOutreachOnsite = "";
    $csmOutreachFinal = "";
    $csmOutreachOffer = "";
    $csmOutreachAccept = "";
    $csmOutreachDecline = "";
    
    $csmHiredCandidates = "";
    $csmHiredPhone = "";
    $csmHiredOnsite = "";
    $csmHiredFinal = "";
    $csmHiredOffer = "";
    $csmHiredAccept = "";
    $csmHiredDecline = "";
    
    $csmGogohireCandidates = "";
    $csmGogohirePhone = "";
    $csmGogohireOnsite = "";
    $csmGogohireFinal = "";
    $csmGogohireOffer = "";
    $csmGogohireAccept = "";
    $csmGogohireDecline = "";
    
    $csmHireUpCandidates = "";
    $csmHireUpPhone = "";
    $csmHireUpOnsite = "";
    $csmHireUpFinal = "";
    $csmHireUpOffer = "";
    $csmHireUpAccept = "";
    $csmHireUpDecline = "";
    
    $csmConferencesCandidates = "";
    $csmConferencesPhone = "";
    $csmConferencesOnsite = "";
    $csmConferencesFinal = "";
    $csmConferencesOffer = "";
    $csmConferencesAccept = "";
    $csmConferencesDecline = "";   

    //Interns
    $internsReferralCandidates = "";
    $internsReferralPhone = "";
    $internsReferralOnsite = "";
    $internsReferralFinal = "";
    $internsReferralOffer = "";
    $internsReferralAccept = "";
    $internsReferralDecline = "";

    $internsAngelListCandidates = "";
    $internsAngelListPhone = "";
    $internsAngelListOnsite = "";
    $internsAngelListFinal = "";
    $internsAngelListOffer = "";
    $internsAngelListAccept = "";
    $internsAngelListDecline = "";
        
    $internsCareerSiteCandidates = "";
    $internsCareerSitePhone = "";
    $internsCareerSiteOnsite = "";
    $internsCareerSiteFinal = "";
    $internsCareerSiteOffer = "";
    $internsCareerSiteAccept = "";
    $internsCareerSiteDecline = "";
        
    $internsOutreachCandidates = "";
    $internsOutreachPhone = "";
    $internsOutreachOnsite = "";
    $internsOutreachFinal = "";
    $internsOutreachOffer = "";
    $internsOutreachAccept = "";
    $internsOutreachDecline = "";
    
    $internsHiredCandidates = "";
    $internsHiredPhone = "";
    $internsHiredOnsite = "";
    $internsHiredFinal = "";
    $internsHiredOffer = "";
    $internsHiredAccept = "";
    $internsHiredDecline = "";
    
    $internsGogohireCandidates = "";
    $internsGogohirePhone = "";
    $internsGogohireOnsite = "";
    $internsGogohireFinal = "";
    $internsGogohireOffer = "";
    $internsGogohireAccept = "";
    $internsGogohireDecline = "";
    
    $internsHireUpCandidates = "";
    $internsHireUpPhone = "";
    $internsHireUpOnsite = "";
    $internsHireUpFinal = "";
    $internsHireUpOffer = "";
    $internsHireUpAccept = "";
    $internsHireUpDecline = "";
    
    $internsConferencesCandidates = "";
    $internsConferencesPhone = "";
    $internsConferencesOnsite = "";
    $internsConferencesFinal = "";
    $internsConferencesOffer = "";
    $internsConferencesAccept = "";
    $internsConferencesDecline = "";

    $none = "";

    $dom = new DOMDocument();
    $path = "/Applications/AMPPS/www/html/editStats.php";
    $html = file_get_contents($path); 
    $dom->loadHTML($html);

    $input = $dom->getElementsByTagName('input');
    for($i=0; $i<$input->length; $i++){
        $name = $input->item($i)->getAttribute('name');
        // Sales
        if ($name == 'salesReferralCandidates' ? $salesReferralCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesReferralPhone' ? $salesReferralPhone = $_POST[$name] : $none = "");
        if ($name == 'salesReferralOnsite' ? $salesReferralOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesReferralFinal' ? $salesReferralFinal = $_POST[$name] : $none = "");
        if ($name == 'salesReferralOffer' ? $salesReferralOffer = $_POST[$name] : $none = "");
        if ($name == 'salesReferralAccept' ? $salesReferralAccept = $_POST[$name] : $none = "");
        if ($name == 'salesReferralDecline' ? $salesReferralDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesAngelListCandidates' ? $salesAngelListCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListPhone' ? $salesAngelListPhone = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListOnsite' ? $salesAngelListOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListFinal' ? $salesAngelListFinal = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListOffer' ? $salesAngelListOffer = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListAccept' ? $salesAngelListAccept = $_POST[$name] : $none = "");
        if ($name == 'salesAngelListDecline' ? $salesAngelListDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesCareerSiteCandidates' ? $salesCareerSiteCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSitePhone' ? $salesCareerSitePhone = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSiteOnsite' ? $salesCareerSiteOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSiteFinal' ? $salesCareerSiteFinal = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSiteOffer' ? $salesCareerSiteOffer = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSiteAccept' ? $salesCareerSiteAccept = $_POST[$name] : $none = "");
        if ($name == 'salesCareerSiteDecline' ? $salesCareerSiteDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesOutreachCandidates' ? $salesOutreachCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachPhone' ? $salesOutreachPhone = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachOnsite' ? $salesOutreachOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachFinal' ? $salesOutreachFinal = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachOffer' ? $salesOutreachOffer = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachAccept' ? $salesOutreachAccept = $_POST[$name] : $none = "");
        if ($name == 'salesOutreachDecline' ? $salesOutreachDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesHiredCandidates' ? $salesHiredCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesHiredPhone' ? $salesHiredPhone = $_POST[$name] : $none = "");
        if ($name == 'salesHiredOnsite' ? $salesHiredOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesHiredFinal' ? $salesHiredFinal = $_POST[$name] : $none = "");
        if ($name == 'salesHiredOffer' ? $salesHiredOffer = $_POST[$name] : $none = "");
        if ($name == 'salesHiredAccept' ? $salesHiredAccept = $_POST[$name] : $none = "");
        if ($name == 'salesHiredDecline' ? $salesHiredDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesGogohireCandidates' ? $salesGogohireCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesGogohirePhone' ? $salesGogohirePhone = $_POST[$name] : $none = "");
        if ($name == 'salesGogohireOnsite' ? $salesGogohireOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesGogohireFinal' ? $salesGogohireFinal = $_POST[$name] : $none = "");
        if ($name == 'salesGogohireOffer' ? $salesGogohireOffer = $_POST[$name] : $none = "");
        if ($name == 'salesGogohireAccept' ? $salesGogohireAccept = $_POST[$name] : $none = "");
        if ($name == 'salesGogohireDecline' ? $salesGogohireDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesHireUpCandidates' ? $salesHireUpCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpPhone' ? $salesHireUpPhone = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpOnsite' ? $salesHireUpOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpFinal' ? $salesHireUpFinal = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpOffer' ? $salesHireUpOffer = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpAccept' ? $salesHireUpAccept = $_POST[$name] : $none = "");
        if ($name == 'salesHireUpDecline' ? $salesHireUpDecline = $_POST[$name] : $none = "");
        
        if ($name == 'salesConferencesCandidates' ? $salesConferencesCandidates = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesPhone' ? $salesConferencesPhone = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesOnsite' ? $salesConferencesOnsite = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesFinal' ? $salesConferencesFinal = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesOffer' ? $salesConferencesOffer = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesAccept' ? $salesConferencesAccept = $_POST[$name] : $none = "");
        if ($name == 'salesConferencesDecline' ? $salesConferencesDecline = $_POST[$name] : $none = "");
        
        //Engineering
        if ($name == 'engReferralCandidates' ? $engReferralCandidates = $_POST[$name] : $none = "");
        if ($name == 'engReferralPhone' ? $engReferralPhone = $_POST[$name] : $none = "");
        if ($name == 'engReferralOnsite' ? $engReferralOnsite = $_POST[$name] : $none = "");
        if ($name == 'engReferralFinal' ? $engReferralFinal = $_POST[$name] : $none = "");
        if ($name == 'engReferralOffer' ? $engReferralOffer = $_POST[$name] : $none = "");
        if ($name == 'engReferralAccept' ? $engReferralAccept = $_POST[$name] : $none = "");
        if ($name == 'engReferralDecline' ? $engReferralDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engAngelListCandidates' ? $engAngelListCandidates = $_POST[$name] : $none = "");
        if ($name == 'engAngelListPhone' ? $engAngelListPhone = $_POST[$name] : $none = "");
        if ($name == 'engAngelListOnsite' ? $engAngelListOnsite = $_POST[$name] : $none = "");
        if ($name == 'engAngelListFinal' ? $engAngelListFinal = $_POST[$name] : $none = "");
        if ($name == 'engAngelListOffer' ? $engAngelListOffer = $_POST[$name] : $none = "");
        if ($name == 'engAngelListAccept' ? $engAngelListAccept = $_POST[$name] : $none = "");
        if ($name == 'engAngelListDecline' ? $engAngelListDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engCareerSiteCandidates' ? $engCareerSiteCandidates = $_POST[$name] : $none = "");
        if ($name == 'engCareerSitePhone' ? $engCareerSitePhone = $_POST[$name] : $none = "");
        if ($name == 'engCareerSiteOnsite' ? $engCareerSiteOnsite = $_POST[$name] : $none = "");
        if ($name == 'engCareerSiteFinal' ? $engCareerSiteFinal = $_POST[$name] : $none = "");
        if ($name == 'engCareerSiteOffer' ? $engCareerSiteOffer = $_POST[$name] : $none = "");
        if ($name == 'engCareerSiteAccept' ? $engCareerSiteAccept = $_POST[$name] : $none = "");
        if ($name == 'engCareerSiteDecline' ? $engCareerSiteDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engOutreachCandidates' ? $engOutreachCandidates = $_POST[$name] : $none = "");
        if ($name == 'engOutreachPhone' ? $engOutreachPhone = $_POST[$name] : $none = "");
        if ($name == 'engOutreachOnsite' ? $engOutreachOnsite = $_POST[$name] : $none = "");
        if ($name == 'engOutreachFinal' ? $engOutreachFinal = $_POST[$name] : $none = "");
        if ($name == 'engOutreachOffer' ? $engOutreachOffer = $_POST[$name] : $none = "");
        if ($name == 'engOutreachAccept' ? $engOutreachAccept = $_POST[$name] : $none = "");
        if ($name == 'engOutreachDecline' ? $engOutreachDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engHiredCandidates' ? $engHiredCandidates = $_POST[$name] : $none = "");
        if ($name == 'engHiredPhone' ? $engHiredPhone = $_POST[$name] : $none = "");
        if ($name == 'engHiredOnsite' ? $engHiredOnsite = $_POST[$name] : $none = "");
        if ($name == 'engHiredFinal' ? $engHiredFinal = $_POST[$name] : $none = "");
        if ($name == 'engHiredOffer' ? $engHiredOffer = $_POST[$name] : $none = "");
        if ($name == 'engHiredAccept' ? $engHiredAccept = $_POST[$name] : $none = "");
        if ($name == 'engHiredDecline' ? $engHiredDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engGogohireCandidates' ? $engGogohireCandidates = $_POST[$name] : $none = "");
        if ($name == 'engGogohirePhone' ? $engGogohirePhone = $_POST[$name] : $none = "");
        if ($name == 'engGogohireOnsite' ? $engGogohireOnsite = $_POST[$name] : $none = "");
        if ($name == 'engGogohireFinal' ? $engGogohireFinal = $_POST[$name] : $none = "");
        if ($name == 'engGogohireOffer' ? $engGogohireOffer = $_POST[$name] : $none = "");
        if ($name == 'engGogohireAccept' ? $engGogohireAccept = $_POST[$name] : $none = "");
        if ($name == 'engGogohireDecline' ? $engGogohireDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engHireUpCandidates' ? $engHireUpCandidates = $_POST[$name] : $none = "");
        if ($name == 'engHireUpPhone' ? $engHireUpPhone = $_POST[$name] : $none = "");
        if ($name == 'engHireUpOnsite' ? $engHireUpOnsite = $_POST[$name] : $none = "");
        if ($name == 'engHireUpFinal' ? $engHireUpFinal = $_POST[$name] : $none = "");
        if ($name == 'engHireUpOffer' ? $engHireUpOffer = $_POST[$name] : $none = "");
        if ($name == 'engHireUpAccept' ? $engHireUpAccept = $_POST[$name] : $none = "");
        if ($name == 'engHireUpDecline' ? $engHireUpDecline = $_POST[$name] : $none = "");
        
        if ($name == 'engConferencesCandidates' ? $engConferencesCandidates = $_POST[$name] : $none = "");
        if ($name == 'engConferencesPhone' ? $engConferencesPhone = $_POST[$name] : $none = "");
        if ($name == 'engConferencesOnsite' ? $engConferencesOnsite = $_POST[$name] : $none = "");
        if ($name == 'engConferencesFinal' ? $engConferencesFinal = $_POST[$name] : $none = "");
        if ($name == 'engConferencesOffer' ? $engConferencesOffer = $_POST[$name] : $none = "");
        if ($name == 'engConferencesAccept' ? $engConferencesAccept = $_POST[$name] : $none = "");
        if ($name == 'engConferencesDecline' ? $engConferencesDecline = $_POST[$name] : $none = "");
        
        //CSM
        if ($name == 'csmReferralCandidates' ? $csmReferralCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmReferralPhone' ? $csmReferralPhone = $_POST[$name] : $none = "");
        if ($name == 'csmReferralOnsite' ? $csmReferralOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmReferralFinal' ? $csmReferralFinal = $_POST[$name] : $none = "");
        if ($name == 'csmReferralOffer' ? $csmReferralOffer = $_POST[$name] : $none = "");
        if ($name == 'csmReferralAccept' ? $csmReferralAccept = $_POST[$name] : $none = "");
        if ($name == 'csmReferralDecline' ? $csmReferralDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmAngelListCandidates' ? $csmAngelListCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListPhone' ? $csmAngelListPhone = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListOnsite' ? $csmAngelListOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListFinal' ? $csmAngelListFinal = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListOffer' ? $csmAngelListOffer = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListAccept' ? $csmAngelListAccept = $_POST[$name] : $none = "");
        if ($name == 'csmAngelListDecline' ? $csmAngelListDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmCareerSiteCandidates' ? $csmCareerSiteCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSitePhone' ? $csmCareerSitePhone = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSiteOnsite' ? $csmCareerSiteOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSiteFinal' ? $csmCareerSiteFinal = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSiteOffer' ? $csmCareerSiteOffer = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSiteAccept' ? $csmCareerSiteAccept = $_POST[$name] : $none = "");
        if ($name == 'csmCareerSiteDecline' ? $csmCareerSiteDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmOutreachCandidates' ? $csmOutreachCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachPhone' ? $csmOutreachPhone = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachOnsite' ? $csmOutreachOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachFinal' ? $csmOutreachFinal = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachOffer' ? $csmOutreachOffer = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachAccept' ? $csmOutreachAccept = $_POST[$name] : $none = "");
        if ($name == 'csmOutreachDecline' ? $csmOutreachDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmHiredCandidates' ? $csmHiredCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmHiredPhone' ? $csmHiredPhone = $_POST[$name] : $none = "");
        if ($name == 'csmHiredOnsite' ? $csmHiredOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmHiredFinal' ? $csmHiredFinal = $_POST[$name] : $none = "");
        if ($name == 'csmHiredOffer' ? $csmHiredOffer = $_POST[$name] : $none = "");
        if ($name == 'csmHiredAccept' ? $csmHiredAccept = $_POST[$name] : $none = "");
        if ($name == 'csmHiredDecline' ? $csmHiredDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmGogohireCandidates' ? $csmGogohireCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmGogohirePhone' ? $csmGogohirePhone = $_POST[$name] : $none = "");
        if ($name == 'csmGogohireOnsite' ? $csmGogohireOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmGogohireFinal' ? $csmGogohireFinal = $_POST[$name] : $none = "");
        if ($name == 'csmGogohireOffer' ? $csmGogohireOffer = $_POST[$name] : $none = "");
        if ($name == 'csmGogohireAccept' ? $csmGogohireAccept = $_POST[$name] : $none = "");
        if ($name == 'csmGogohireDecline' ? $csmGogohireDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmHireUpCandidates' ? $csmHireUpCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpPhone' ? $csmHireUpPhone = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpOnsite' ? $csmHireUpOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpFinal' ? $csmHireUpFinal = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpOffer' ? $csmHireUpOffer = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpAccept' ? $csmHireUpAccept = $_POST[$name] : $none = "");
        if ($name == 'csmHireUpDecline' ? $csmHireUpDecline = $_POST[$name] : $none = "");
        
        if ($name == 'csmConferencesCandidates' ? $csmConferencesCandidates = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesPhone' ? $csmConferencesPhone = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesOnsite' ? $csmConferencesOnsite = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesFinal' ? $csmConferencesFinal = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesOffer' ? $csmConferencesOffer = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesAccept' ? $csmConferencesAccept = $_POST[$name] : $none = "");
        if ($name == 'csmConferencesDecline' ? $csmConferencesDecline = $_POST[$name] : $none = "");
        
        //Interns
        if ($name == 'internsReferralCandidates' ? $internsReferralCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsReferralPhone' ? $internsReferralPhone = $_POST[$name] : $none = "");
        if ($name == 'internsReferralOnsite' ? $internsReferralOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsReferralFinal' ? $internsReferralFinal = $_POST[$name] : $none = "");
        if ($name == 'internsReferralOffer' ? $internsReferralOffer = $_POST[$name] : $none = "");
        if ($name == 'internsReferralAccept' ? $internsReferralAccept = $_POST[$name] : $none = "");
        if ($name == 'internsReferralDecline' ? $internsReferralDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsAngelListCandidates' ? $internsAngelListCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListPhone' ? $internsAngelListPhone = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListOnsite' ? $internsAngelListOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListFinal' ? $internsAngelListFinal = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListOffer' ? $internsAngelListOffer = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListAccept' ? $internsAngelListAccept = $_POST[$name] : $none = "");
        if ($name == 'internsAngelListDecline' ? $internsAngelListDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsCareerSiteCandidates' ? $internsCareerSiteCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSitePhone' ? $internsCareerSitePhone = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSiteOnsite' ? $internsCareerSiteOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSiteFinal' ? $internsCareerSiteFinal = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSiteOffer' ? $internsCareerSiteOffer = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSiteAccept' ? $internsCareerSiteAccept = $_POST[$name] : $none = "");
        if ($name == 'internsCareerSiteDecline' ? $internsCareerSiteDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsOutreachCandidates' ? $internsOutreachCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachPhone' ? $internsOutreachPhone = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachOnsite' ? $internsOutreachOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachFinal' ? $internsOutreachFinal = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachOffer' ? $internsOutreachOffer = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachAccept' ? $internsOutreachAccept = $_POST[$name] : $none = "");
        if ($name == 'internsOutreachDecline' ? $internsOutreachDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsHiredCandidates' ? $internsHiredCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsHiredPhone' ? $internsHiredPhone = $_POST[$name] : $none = "");
        if ($name == 'internsHiredOnsite' ? $internsHiredOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsHiredFinal' ? $internsHiredFinal = $_POST[$name] : $none = "");
        if ($name == 'internsHiredOffer' ? $internsHiredOffer = $_POST[$name] : $none = "");
        if ($name == 'internsHiredAccept' ? $internsHiredAccept = $_POST[$name] : $none = "");
        if ($name == 'internsHiredDecline' ? $internsHiredDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsGogohireCandidates' ? $internsGogohireCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsGogohirePhone' ? $internsGogohirePhone = $_POST[$name] : $none = "");
        if ($name == 'internsGogohireOnsite' ? $internsGogohireOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsGogohireFinal' ? $internsGogohireFinal = $_POST[$name] : $none = "");
        if ($name == 'internsGogohireOffer' ? $internsGogohireOffer = $_POST[$name] : $none = "");
        if ($name == 'internsGogohireAccept' ? $internsGogohireAccept = $_POST[$name] : $none = "");
        if ($name == 'internsGogohireDecline' ? $internsGogohireDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsHireUpCandidates' ? $internsHireUpCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpPhone' ? $internsHireUpPhone = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpOnsite' ? $internsHireUpOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpFinal' ? $internsHireUpFinal = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpOffer' ? $internsHireUpOffer = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpAccept' ? $internsHireUpAccept = $_POST[$name] : $none = "");
        if ($name == 'internsHireUpDecline' ? $internsHireUpDecline = $_POST[$name] : $none = "");
        
        if ($name == 'internsConferencesCandidates' ? $internsConferencesCandidates = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesPhone' ? $internsConferencesPhone = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesOnsite' ? $internsConferencesOnsite = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesFinal' ? $internsConferencesFinal = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesOffer' ? $internsConferencesOffer = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesAccept' ? $internsConferencesAccept = $_POST[$name] : $none = "");
        if ($name == 'internsConferencesDecline' ? $internsConferencesDecline = $_POST[$name] : $none = "");
    }

    $select = $dom->getElementsByTagName('select');
    for($i=0; $i<$select->length; $i++){
        $name = $select->item($i)->getAttribute('name');

        if ($name == 'statsMonth' ? $statsMonth = $_POST[$name] : $none = "");
        if ($name == 'statsYear' ? $statsYear = $_POST[$name] : $none = "");
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";
    
    $whereStr = "";
    
    $whereStr = "statsMonth='$statsMonth' AND statsYear='$statsYear'";
    
    $sql = "UPDATE Stats SET salesReferralCandidates = '$salesReferralCandidates', salesReferralPhone = '$salesReferralPhone', salesReferralOnsite = '$salesReferralOnsite', salesReferralFinal = '$salesReferralFinal', salesReferralOffer = '$salesReferralOffer', salesReferralAccept = '$salesReferralAccept', salesReferralDecline = '$salesReferralDecline', salesAngelListCandidates = '$salesAngelListCandidates', salesAngelListPhone = '$salesAngelListPhone', salesAngelListOnsite = '$salesAngelListOnsite', salesAngelListFinal = '$salesAngelListFinal', salesAngelListOffer = '$salesAngelListOffer', salesAngelListAccept = '$salesAngelListAccept',salesAngelListDecline = '$salesAngelListDecline', salesCareerSiteCandidates = '$salesCareerSiteCandidates', salesCareerSitePhone = '$salesCareerSitePhone', salesCareerSiteOnsite = '$salesCareerSiteOnsite', salesCareerSiteFinal = '$salesCareerSiteFinal', salesCareerSiteOffer = '$salesCareerSiteOffer', salesCareerSiteAccept = '$salesCareerSiteAccept', salesCareerSiteDecline = '$salesCareerSiteDecline', salesOutreachCandidates = '$salesOutreachCandidates', salesOutreachPhone = '$salesOutreachPhone', salesOutreachOnsite = '$salesOutreachOnsite', salesOutreachFinal = '$salesOutreachFinal', salesOutreachOffer = '$salesOutreachOffer', salesOutreachAccept = '$salesOutreachAccept', salesOutreachDecline = '$salesOutreachDecline', salesHiredCandidates = '$salesHiredCandidates', salesHiredPhone = '$salesHiredPhone', salesHiredOnsite = '$salesHiredOnsite', salesHiredFinal = '$salesHiredFinal', salesHiredOffer = '$salesHiredOffer', salesHiredAccept = '$salesHiredAccept', salesHiredDecline = '$salesHiredDecline', salesGogohireCandidates = '$salesGogohireCandidates', salesGogohirePhone = '$salesGogohirePhone', salesGogohireOnsite = '$salesGogohireOnsite', salesGogohireFinal = '$salesGogohireFinal', salesGogohireOffer = '$salesGogohireOffer', salesGogohireAccept = '$salesGogohireAccept', salesGogohireDecline = '$salesGogohireDecline', salesHireUpCandidates = '$salesHireUpCandidates', salesHireUpPhone = '$salesHireUpPhone', salesHireUpOnsite = '$salesHireUpOnsite', salesHireUpFinal = '$salesHireUpFinal', salesHireUpOffer = '$salesHireUpOffer', salesHireUpAccept = '$salesHireUpAccept', salesHireUpDecline = '$salesHireUpDecline', salesConferencesCandidates = '$salesConferencesCandidates', salesConferencesPhone = '$salesConferencesPhone', salesConferencesOnsite = '$salesConferencesOnsite', salesConferencesFinal = '$salesConferencesFinal', salesConferencesOffer = '$salesConferencesOffer', salesConferencesAccept = '$salesConferencesAccept', salesConferencesDecline = '$salesConferencesDecline', engReferralCandidates = '$engReferralCandidates', engReferralPhone = '$engReferralPhone', engReferralOnsite = '$engReferralOnsite', engReferralFinal = '$engReferralFinal', engReferralOffer = '$engReferralOffer', engReferralAccept = '$engReferralAccept', engReferralDecline = '$engReferralDecline', engAngelListCandidates = '$engAngelListCandidates', engAngelListPhone = '$engAngelListPhone', engAngelListOnsite = '$engAngelListOnsite', engAngelListFinal = '$engAngelListFinal', engAngelListOffer = '$engAngelListOffer', engAngelListAccept = '$engAngelListAccept',engAngelListDecline = '$engAngelListDecline', engCareerSiteCandidates = '$engCareerSiteCandidates', engCareerSitePhone = '$engCareerSitePhone', engCareerSiteOnsite = '$engCareerSiteOnsite', engCareerSiteFinal = '$engCareerSiteFinal', engCareerSiteOffer = '$engCareerSiteOffer', engCareerSiteAccept = '$engCareerSiteAccept', engCareerSiteDecline = '$engCareerSiteDecline', engOutreachCandidates = '$engOutreachCandidates', engOutreachPhone = '$engOutreachPhone', engOutreachOnsite = '$engOutreachOnsite', engOutreachFinal = '$engOutreachFinal', engOutreachOffer = '$engOutreachOffer', engOutreachAccept = '$engOutreachAccept', engOutreachDecline = '$engOutreachDecline', engHiredCandidates = '$engHiredCandidates', engHiredPhone = '$engHiredPhone', engHiredOnsite = '$engHiredOnsite', engHiredFinal = '$engHiredFinal', engHiredOffer = '$engHiredOffer', engHiredAccept = '$engHiredAccept', engHiredDecline = '$engHiredDecline', engGogohireCandidates = '$engGogohireCandidates', engGogohirePhone = '$engGogohirePhone', engGogohireOnsite = '$engGogohireOnsite', engGogohireFinal = '$engGogohireFinal', engGogohireOffer = '$engGogohireOffer', engGogohireAccept = '$engGogohireAccept', engGogohireDecline = '$engGogohireDecline', engHireUpCandidates = '$engHireUpCandidates', engHireUpPhone = '$engHireUpPhone', engHireUpOnsite = '$engHireUpOnsite', engHireUpFinal = '$engHireUpFinal', engHireUpOffer = '$engHireUpOffer', engHireUpAccept = '$engHireUpAccept', engHireUpDecline = '$engHireUpDecline', engConferencesCandidates = '$engConferencesCandidates', engConferencesPhone = '$engConferencesPhone', engConferencesOnsite = '$engConferencesOnsite', engConferencesFinal = '$engConferencesFinal', engConferencesOffer = '$engConferencesOffer', engConferencesAccept = '$engConferencesAccept', engConferencesDecline = '$engConferencesDecline', csmReferralCandidates = '$csmReferralCandidates', csmReferralPhone = '$csmReferralPhone', csmReferralOnsite = '$csmReferralOnsite', csmReferralFinal = '$csmReferralFinal', csmReferralOffer = '$csmReferralOffer', csmReferralAccept = '$csmReferralAccept', csmReferralDecline = '$csmReferralDecline', csmAngelListCandidates = '$csmAngelListCandidates', csmAngelListPhone = '$csmAngelListPhone', csmAngelListOnsite = '$csmAngelListOnsite', csmAngelListFinal = '$csmAngelListFinal', csmAngelListOffer = '$csmAngelListOffer', csmAngelListAccept = '$csmAngelListAccept',csmAngelListDecline = '$csmAngelListDecline', csmCareerSiteCandidates = '$csmCareerSiteCandidates', csmCareerSitePhone = '$csmCareerSitePhone', csmCareerSiteOnsite = '$csmCareerSiteOnsite', csmCareerSiteFinal = '$csmCareerSiteFinal', csmCareerSiteOffer = '$csmCareerSiteOffer', csmCareerSiteAccept = '$csmCareerSiteAccept', csmCareerSiteDecline = '$csmCareerSiteDecline', csmOutreachCandidates = '$csmOutreachCandidates', csmOutreachPhone = '$csmOutreachPhone', csmOutreachOnsite = '$csmOutreachOnsite', csmOutreachFinal = '$csmOutreachFinal', csmOutreachOffer = '$csmOutreachOffer', csmOutreachAccept = '$csmOutreachAccept', csmOutreachDecline = '$csmOutreachDecline', csmHiredCandidates = '$csmHiredCandidates', csmHiredPhone = '$csmHiredPhone', csmHiredOnsite = '$csmHiredOnsite', csmHiredFinal = '$csmHiredFinal', csmHiredOffer = '$csmHiredOffer', csmHiredAccept = '$csmHiredAccept', csmHiredDecline = '$csmHiredDecline', csmGogohireCandidates = '$csmGogohireCandidates', csmGogohirePhone = '$csmGogohirePhone', csmGogohireOnsite = '$csmGogohireOnsite', csmGogohireFinal = '$csmGogohireFinal', csmGogohireOffer = '$csmGogohireOffer', csmGogohireAccept = '$csmGogohireAccept', csmGogohireDecline = '$csmGogohireDecline', csmHireUpCandidates = '$csmHireUpCandidates', csmHireUpPhone = '$csmHireUpPhone', csmHireUpOnsite = '$csmHireUpOnsite', csmHireUpFinal = '$csmHireUpFinal', csmHireUpOffer = '$csmHireUpOffer', csmHireUpAccept = '$csmHireUpAccept', csmHireUpDecline = '$csmHireUpDecline', csmConferencesCandidates = '$csmConferencesCandidates', csmConferencesPhone = '$csmConferencesPhone', csmConferencesOnsite = '$csmConferencesOnsite', csmConferencesFinal = '$csmConferencesFinal', csmConferencesOffer = '$csmConferencesOffer', csmConferencesAccept = '$csmConferencesAccept', csmConferencesDecline = '$csmConferencesDecline', internsReferralCandidates = '$internsReferralCandidates', internsReferralPhone = '$internsReferralPhone', internsReferralOnsite = '$internsReferralOnsite', internsReferralFinal = '$internsReferralFinal', internsReferralOffer = '$internsReferralOffer', internsReferralAccept = '$internsReferralAccept', internsReferralDecline = '$internsReferralDecline', internsAngelListCandidates = '$internsAngelListCandidates', internsAngelListPhone = '$internsAngelListPhone', internsAngelListOnsite = '$internsAngelListOnsite', internsAngelListFinal = '$internsAngelListFinal', internsAngelListOffer = '$internsAngelListOffer', internsAngelListAccept = '$internsAngelListAccept',internsAngelListDecline = '$internsAngelListDecline', internsCareerSiteCandidates = '$internsCareerSiteCandidates', internsCareerSitePhone = '$internsCareerSitePhone', internsCareerSiteOnsite = '$internsCareerSiteOnsite', internsCareerSiteFinal = '$internsCareerSiteFinal', internsCareerSiteOffer = '$internsCareerSiteOffer', internsCareerSiteAccept = '$internsCareerSiteAccept', internsCareerSiteDecline = '$internsCareerSiteDecline', internsOutreachCandidates = '$internsOutreachCandidates', internsOutreachPhone = '$internsOutreachPhone', internsOutreachOnsite = '$internsOutreachOnsite', internsOutreachFinal = '$internsOutreachFinal', internsOutreachOffer = '$internsOutreachOffer', internsOutreachAccept = '$internsOutreachAccept', internsOutreachDecline = '$internsOutreachDecline', internsHiredCandidates = '$internsHiredCandidates', internsHiredPhone = '$internsHiredPhone', internsHiredOnsite = '$internsHiredOnsite', internsHiredFinal = '$internsHiredFinal', internsHiredOffer = '$internsHiredOffer', internsHiredAccept = '$internsHiredAccept', internsHiredDecline = '$internsHiredDecline', internsGogohireCandidates = '$internsGogohireCandidates', internsGogohirePhone = '$internsGogohirePhone', internsGogohireOnsite = '$internsGogohireOnsite', internsGogohireFinal = '$internsGogohireFinal', internsGogohireOffer = '$internsGogohireOffer', internsGogohireAccept = '$internsGogohireAccept', internsGogohireDecline = '$internsGogohireDecline', internsHireUpCandidates = '$internsHireUpCandidates', internsHireUpPhone = '$internsHireUpPhone', internsHireUpOnsite = '$internsHireUpOnsite', internsHireUpFinal = '$internsHireUpFinal', internsHireUpOffer = '$internsHireUpOffer', internsHireUpAccept = '$internsHireUpAccept', internsHireUpDecline = '$internsHireUpDecline', internsConferencesCandidates = '$internsConferencesCandidates', internsConferencesPhone = '$internsConferencesPhone', internsConferencesOnsite = '$internsConferencesOnsite', internsConferencesFinal = '$internsConferencesFinal', internsConferencesOffer = '$internsConferencesOffer', internsConferencesAccept = '$internsConferencesAccept', internsConferencesDecline = '$internsConferencesDecline' WHERE ".$whereStr;
         
         
    if(!isset($statsMonth) || !isset($statsYear)){
        header("Location: ../html/editStats.php?id=invalidDate");
         $sql = "";
    }
    
    if($statsMonth == 0 || $statsYear == 0){
        header("Location: ../html/editStats.php?id=invalidDate");
        $sql = "";
    }
    
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
        header("Location: ../html/editStats.php?id=yes&month=".$statsMonth."&year=".$statsYear);
    } else {
        echo "Error creating table: " . $conn->error;
    }
    
}

function reportStats($flag) {
    
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "HR_DB";
    $port = 3306;

    $statsMonth = 0;
    $statsYear = 0;
    

    $none = "";

    $dom = new DOMDocument();
    $path = "/Applications/AMPPS/www/html/reportStats.php";
    $html = file_get_contents($path); 
    $dom->loadHTML($html);

    $select = $dom->getElementsByTagName('select');
    for($i=0; $i<$select->length; $i++){
        $name = $select->item($i)->getAttribute('name');

        if ($name == 'statsMonth' ? $statsMonth = intval( $_POST[$name]) : $none = "");
        if ($name == 'statsYear' ? $statsYear = intval( $_POST[$name]): $none = "");
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";
    
    if(!isset($statsMonth) || !isset($statsYear)){
        header("Location: ../html/reportStats.php?id=invalidDate");
    }
    
    if($statsMonth == 0 || $statsYear == 0){
        header("Location: ../html/reportStats.php?id=invalidDate");
    }

    $sql = "";
    
    switch ($flag){
        case 1:
            $sql = "SELECT * FROM Stats";
            break;
        default:
            $sql = "SELECT * FROM Stats";
            break;
    }
    
    $result = $conn->query($sql);
    
    $resultArray = array();
    
    while($row = mysqli_fetch_array($result)) {
        array_push($resultArray, $row);
    }
    
    if(isset($resultArray) && count($resultArray)>0){
        $_SESSION['resultArray'] = $resultArray;
         header("Location: ../html/reportStats.php?id=no&month=".$statsMonth."&year=".$statsYear);
    } else {
        echo "Query error!";
        echo $sql;
    }
    
    $conn->close(); 
 
}

?>