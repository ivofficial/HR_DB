$(document).ready(function() {

    var tblID = '#resultsTable';
    var htmlTblID = 'resultsTable'
    var fltFld = $('#filterInput');
    
    var tbl = $(tblID);
    
    $(tblID).tablesorter();
    
    $('#exportButton').click( function(){
       tbl.table2excel({
           exclude: ".noExl",
           name: "Candidates",
           filename: "Search_Results"
       })
    });
    
    //Capture filter input one character at a time
    fltFld.keyup( function() {
        filterTable(tblID, fltFld.val());      
    });

    //split filter input into words, using blank space as a word seperator
    var parseFilter = function ($txt) {
        var $words = $txt.split(" ");

        return $words;
    }
    

    //Check if all the elements in a string array are contained in a single text string
    var isMatch = function($txt, $arr) {
        var match = false;
        for( $i=0; $i<$arr.length; $i++){
            if($txt.toLowerCase().includes($arr[$i].toLowerCase())) {
                match = true;
            } else {
                match = false;
                break;
            }
        }
        
        return match;
    }
    
    //Check if the words in the filter input matches the contents of any of the table rows and then hide those rows where it doesn't
    var filterTable = function($tableID, $txt) {
        var $strArr = parseFilter($txt);
        if($strArr.length > 0) {
            var rows = $($tableID+' tbody tr');
            rows.each( function () {
                if ($(this).text().length > 0) {
                    if(isMatch($(this).text(), $strArr)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                }
            });
        }        
    }
    
});