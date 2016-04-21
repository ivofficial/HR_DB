<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="/bootstrap-3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/style/dashboardStyles.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="../bootstrap-3.3.6/js/bootstrap.min.js"  type="text/javascript"></script>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
        <script src="../js/lodash.js"></script>
        
        <title>Conversion Rates</title>
        
        <script type="text/javascript">
        $(document).ready(function() {
                     
            $.ajax({
                type: "GET",
                url:"data.csv",
                dataType: "text",
                success: function(data) {processData(data);}
            });
            
            function processData(allText) {
                
                var dataArray = [];
                var roleArray = ['Sales', 'Engineering', 'CSM', 'Interns'];
                var sourceArray = ['Referral', 'Angel List', 'Career Site', 'Outreach', 'Hired', 'Gogohire', 'HireUp', 'Conferences'];
                var stageArray = ['All Applicants', 'Phone Screen','Onsite', 'Final Onsite', 'Offer', 'Accept', 'Decline'];
                var stageCategoriesArray = ['Phone Screen','Onsite', 'Final Onsite', 'Offer', 'Accept', 'Decline'];
                var monthYearArray = [];
                var uniqueDates = [];
                var salesBySourceRatio = [];
                var engBySourceRatio = [];
                var csmBySourceRatio = [];
                var internsBySourceRatio = [];
                var salesByStageRatio = [];
                var engByStageRatio = [];
                var csmByStageRatio = [];
                var internsByStageRatio = [];
                var applicants = 0;
                var phones = 0;
                var onsites = 0;
                var finalOnsites = 0;
                var offers = 0;
                var accepts = 0;
                var declines = 0;
                var hires = 0;
                
                var allTextLines = allText.split(/\r\n|\n/);
                var headers = allTextLines[0].split(',');
                var lines = [];
                
                //Convert the CSV file into a two-dimensional array 
                for (var i=1; i<allTextLines.length; i++) {
                    var data = allTextLines[i].split(',');
                    if (data.length == headers.length) {
                        var tarr = [];
                        for (var j=0; j<headers.length; j++) {
                            tarr.push(headers[j]+":"+data[j]);
                        }
                        lines.push(tarr);
                        var monthYear = tarr[0].split(":")[1];
                        var month = tarr[1].split(":")[1];
                        var year = tarr[2].split(":")[1]; 
                        var role = tarr[3].split(":")[1];
                        var source = tarr[4].split(":")[1];
                        var stage = tarr[5].split(":")[1];
                        var candidates = +tarr[6].split(":")[1];
                        var tmpArray = [monthYear, month, year, role, source, stage, candidates];
                        dataArray.push(tmpArray);
                        monthYearArray.push(monthYear);
                    }
                }
                
                //Remove duplicate dates using Lodash JS library
                uniqueDates = _.uniq(monthYearArray);
                
                //Conversion By Source
                for (var j=0; j<uniqueDates.length; j++) {
                    var tmpArray = [];
                    applicants = 0;
                    hires = 0;
                    
                    //Sales By Source
                    for (var i =0; i<dataArray.length; i++) {
                        if(dataArray[i][0].indexOf(uniqueDates[j])>=0 ) {
                            if (dataArray[i][3].indexOf(roleArray[0])>=0) {
                                if (dataArray[i][5].indexOf(stageArray[0])>=0){
                                    applicants+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[4])>=0){
                                    hires += dataArray[i][6];
                                    if (applicants !== 0) {
                                        tmpArray.push((hires/applicants)*100); 
                                    } else {
                                        tmpArray.push(0);
                                    }
                                    applicants = 0;
                                    hires = 0;
                                }
                            }
                        }  
                    }
                    salesBySourceRatio.push(tmpArray);
                    
                    //Engineering By Source
                    tmpArray = [];
                    applicants = 0;
                    hires = 0;
                    for (var i =0; i<dataArray.length; i++) {
                        if(dataArray[i][0].indexOf(uniqueDates[j])>=0 ) {
                            if (dataArray[i][3].indexOf(roleArray[1])>=0) {
                                if (dataArray[i][5].indexOf(stageArray[0])>=0){
                                    applicants+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[4])>=0){
                                    hires += dataArray[i][6];
                                    if (applicants !== 0) {
                                        tmpArray.push((hires/applicants)); 
                                    } else {
                                        tmpArray.push(0);
                                    }
                                    applicants = 0;
                                    hires = 0;
                                }
                            }
                        }  
                    }
                    engBySourceRatio.push(tmpArray);
                    
                    //CSM By Source
                    tmpArray = [];
                    applicants = 0;
                    hires = 0;
                    for (var i =0; i<dataArray.length; i++) {
                        if(dataArray[i][0].indexOf(uniqueDates[j])>=0 ) {
                            if (dataArray[i][3].indexOf(roleArray[2])>=0) {
                                if (dataArray[i][5].indexOf(stageArray[0])>=0){
                                    applicants+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[4])>=0){
                                    hires += dataArray[i][6];
                                    if (applicants !== 0) {
                                        tmpArray.push((hires/applicants)); 
                                    } else {
                                        tmpArray.push(0);
                                    }
                                    applicants = 0;
                                    hires = 0;
                                }
                            }
                        }  
                    }
                    csmBySourceRatio.push(tmpArray);
                    
                    //Interns By Source
                    tmpArray = [];
                    applicants = 0;
                    hires = 0;
                    for (var i =0; i<dataArray.length; i++) {
                        if(dataArray[i][0].indexOf(uniqueDates[j])>=0 ) {
                            if (dataArray[i][3].indexOf(roleArray[3])>=0) {
                                if (dataArray[i][5].indexOf(stageArray[0])>=0){
                                    applicants+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[4])>=0){
                                    hires += dataArray[i][6];
                                    if (applicants !== 0) {
                                        tmpArray.push((hires/applicants)); 
                                    } else {
                                        tmpArray.push(0);
                                    }
                                    applicants = 0;
                                    hires = 0;
                                }
                            }
                        }  
                    }
                    internsBySourceRatio.push(tmpArray); 
                }
                
                //Conversion By Stage
                for (var j=0; j<uniqueDates.length; j++) {
                    var tmpArray = [];
                    applicants = 0;
                    phones = 0;
                    onsites = 0;
                    finalOnsites = 0;
                    offers = 0;
                    accepts = 0;
                    declines = 0;
                    
                    //Sales By Stage
                    for (var i =0; i<dataArray.length; i++) {
                        if(dataArray[i][0].indexOf(uniqueDates[j])>=0 ) {
                            if (dataArray[i][3].indexOf(roleArray[0])>=0) {
                                
                                if (dataArray[i][5].indexOf(stageArray[0])>=0){
                                    applicants+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[1])>=0){
                                    phones+= dataArray[i][6];
                                } else if ( (dataArray[i][5].indexOf(stageArray[2])>=0) && (dataArray[i][5].indexOf(stageArray[3])<0) ){
                                    onsites+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[3])>=0){
                                    finalOnsites+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[4])>=0){
                                    offers+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[5])>=0){
                                    accepts+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[6])>=0){
                                    declines += dataArray[i][6];    
                                }
                                
                            }
                            
                        }  
                    }
                    
                    if (applicants !== 0) {
                        tmpArray.push((phones/applicants)*100); 
                        tmpArray.push((onsites/applicants)*100); 
                        tmpArray.push((finalOnsites/applicants)*100); 
                        tmpArray.push((offers/applicants)*100); 
                        tmpArray.push((accepts/applicants)*100); 
                        tmpArray.push((declines/applicants)*100); 
                    } else {
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                    }
                    
                    salesByStageRatio.push(tmpArray);
                    
                    applicants = 0;
                    phones = 0;
                    onsites = 0;
                    finalOnsites = 0;
                    offers = 0;
                    accepts = 0;
                    declines = 0;
                    tmpArray = [];
                    
                    //Engineering By Stage
                    for (var i =0; i<dataArray.length; i++) {
                        if(dataArray[i][0].indexOf(uniqueDates[j])>=0 ) {
                            if (dataArray[i][3].indexOf(roleArray[1])>=0) { 
                                if (dataArray[i][5].indexOf(stageArray[0])>=0){
                                    applicants+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[1])>=0){
                                    phones+= dataArray[i][6];
                                } else if ( (dataArray[i][5].indexOf(stageArray[2])>=0) && (dataArray[i][5].indexOf(stageArray[3])<0) ){
                                    onsites+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[3])>=0){
                                    finalOnsites+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[4])>=0){
                                    offers+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[5])>=0){
                                    accepts+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[6])>=0){
                                    declines += dataArray[i][6];    
                                }
                                
                            }
                            
                        }  
                    }
                    
                    if (applicants !== 0) {
                        tmpArray.push((phones/applicants)*100); 
                        tmpArray.push((onsites/applicants)*100); 
                        tmpArray.push((finalOnsites/applicants)*100); 
                        tmpArray.push((offers/applicants)*100); 
                        tmpArray.push((accepts/applicants)*100); 
                        tmpArray.push((declines/applicants)*100); 
                    } else {
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                    }
                    
                    engByStageRatio.push(tmpArray);
                    
                    applicants = 0;
                    phones = 0;
                    onsites = 0;
                    finalOnsites = 0;
                    offers = 0;
                    accepts = 0;
                    declines = 0;
                    tmpArray = [];
                    
                    //CSM By Stage
                    for (var i =0; i<dataArray.length; i++) {
                        if(dataArray[i][0].indexOf(uniqueDates[j])>=0 ) {
                            if (dataArray[i][3].indexOf(roleArray[2])>=0) { 
                                if (dataArray[i][5].indexOf(stageArray[0])>=0){
                                    applicants+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[1])>=0){
                                    phones+= dataArray[i][6];
                                } else if ( (dataArray[i][5].indexOf(stageArray[2])>=0) && (dataArray[i][5].indexOf(stageArray[3])<0) ){
                                    onsites+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[3])>=0){
                                    finalOnsites+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[4])>=0){
                                    offers+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[5])>=0){
                                    accepts+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[6])>=0){
                                    declines += dataArray[i][6];    
                                }
                                
                            }
                            
                        }  
                    }
                    
                    if (applicants !== 0) {
                        tmpArray.push((phones/applicants)*100); 
                        tmpArray.push((onsites/applicants)*100); 
                        tmpArray.push((finalOnsites/applicants)*100); 
                        tmpArray.push((offers/applicants)*100); 
                        tmpArray.push((accepts/applicants)*100); 
                        tmpArray.push((declines/applicants)*100); 
                    } else {
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                    }
                    
                    csmByStageRatio.push(tmpArray);
                    
                    applicants = 0;
                    phones = 0;
                    onsites = 0;
                    finalOnsites = 0;
                    offers = 0;
                    accepts = 0;
                    declines = 0;
                    tmpArray = [];
                    
                    //Interns By Stage
                    for (var i =0; i<dataArray.length; i++) {
                        if(dataArray[i][0].indexOf(uniqueDates[j])>=0 ) {
                            if (dataArray[i][3].indexOf(roleArray[3])>=0) { 
                                if (dataArray[i][5].indexOf(stageArray[0])>=0){
                                    applicants+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[1])>=0){
                                    phones+= dataArray[i][6];
                                } else if ( (dataArray[i][5].indexOf(stageArray[2])>=0) && (dataArray[i][5].indexOf(stageArray[3])<0) ){
                                    onsites+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[3])>=0){
                                    finalOnsites+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[4])>=0){
                                    offers+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[5])>=0){
                                    accepts+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[6])>=0){
                                    declines += dataArray[i][6];    
                                }
                                
                            }
                            
                        }  
                    }
                    
                    if (applicants !== 0) {
                        tmpArray.push((phones/applicants)*100); 
                        tmpArray.push((onsites/applicants)*100); 
                        tmpArray.push((finalOnsites/applicants)*100); 
                        tmpArray.push((offers/applicants)*100); 
                        tmpArray.push((accepts/applicants)*100); 
                        tmpArray.push((declines/applicants)*100); 
                    } else {
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                        tmpArray.push(0);
                    }
                    
                    internsByStageRatio.push(tmpArray);
                    
                    applicants = 0;
                    phones = 0;
                    onsites = 0;
                    finalOnsites = 0;
                    offers = 0;
                    accepts = 0;
                    declines = 0;
                    tmpArray = [];
                }
                               
                //Setting up the parameters for the charts displaying Conversion Rates By Source
                var chartData = new Object();

                Object.defineProperty(chartData, "name", { value: "Month"});
                Object.defineProperty(chartData, "data", { value: sourceArray});

                var salesArray = [];
                var engArray = [];
                var csmArray = [];
                var internsArray = [];
            
                salesArray.push(chartData);
                engArray.push(chartData);
                csmArray.push(chartData);
                internsArray.push(chartData);
                for(var a=0; a< uniqueDates.length; a++){
                    chartData = new Object();
                    chartData.name = uniqueDates[a];
                    chartData.data = salesBySourceRatio[a];
                    salesArray.push(chartData);
                    
                    chartData = new Object();
                    chartData.name = uniqueDates[a];
                    chartData.data = engBySourceRatio[a];
                    engArray.push(chartData);
                    
                    chartData = new Object();
                    chartData.name = uniqueDates[a];
                    chartData.data = csmBySourceRatio[a];
                    csmArray.push(chartData);
                    
                    chartData = new Object();
                    chartData.name = uniqueDates[a];
                    chartData.data = internsBySourceRatio[a];
                    internsArray.push(chartData);
                }
                
                var salesSourceOptions = {    
                    chart: {
                        renderTo: 'salesContainerBySource',
                        type: 'column',
                        marginRight: 130,
                        marginBottom: 75
                    },
                    title: {
                        text: 'Sales By Source',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: [],
                        labels: {
                            padding: 100
                        },
                        
                    },
                    yAxis: {
                        title: {
                            text: 'Rate, %'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                this.x +': '+ this.y.toFixed(2)+' %';
                        },
                        crosshairs: [true, true]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                formatter: function() {
                                    if (this.y>0){
                                        return '<br/>'+this.y.toFixed(2)+'%';
                                    } else {
                                        return '';
                                    }
                                
                                },
                                enabled: true
                            }
                        }
                    },
                    series: []
                }
                
                var engSourceOptions = {
                    chart: {
                        renderTo: 'engContainerBySource',
                        type: 'column',
                        marginRight: 130,
                        marginBottom: 75
                    },
                    title: {
                        text: 'Engineering By Source',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: []
                    },
                    yAxis: {
                        title: {
                            text: 'Rate, %'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                this.x +': '+ this.y.toFixed(2)+' %';
                        },
                        crosshairs: [true, true]
                    }, 
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                formatter: function() {
                                    if (this.y>0){
                                        return '<br/>'+this.y.toFixed(2)+'%';
                                    } else {
                                        return '';
                                    }
                                
                                },
                                enabled: true
                            }
                        }
                    },
                    series: []
                }
                
                var csmSourceOptions = {
                    chart: {
                        renderTo: 'csmContainerBySource',
                        type: 'column',
                        marginRight: 130,
                        marginBottom: 75
                    },
                    title: {
                        text: 'CSM By Source',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: []
                    },
                    yAxis: {
                        title: {
                            text: 'Rate, %'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                this.x +': '+ this.y.toFixed(2)+' %';
                        },
                        crosshairs: [true, true]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                formatter: function() {
                                    if (this.y>0){
                                        return '<br/>'+this.y.toFixed(2)+'%';
                                    } else {
                                        return '';
                                    }
                                
                                },
                                enabled: true
                            }
                        }
                    },
                    series: []
                }
                
                var internsSourceOptions = {
                    chart: {
                        renderTo: 'internsContainerBySource',
                        type: 'column',
                        marginRight: 130,
                        marginBottom: 75
                    },
                    title: {
                        text: 'Interns By Source',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: []
                    },
                    yAxis: {
                        title: {
                            text: 'Rate, %'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                this.x +': '+ this.y.toFixed(2)+' %';
                        },
                        crosshairs: [true, true]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                formatter: function() {
                                    if (this.y>0){
                                        return '<br/>'+this.y.toFixed(2)+'%';
                                    } else {
                                        return '';
                                    }
                                
                                },
                                enabled: true
                            }
                        }
                    },
                    series: []
                }
                
                salesSourceOptions.xAxis.categories = sourceArray;
                for (var salesIndex = 0; salesIndex < salesArray.length-1; salesIndex++){
                    salesSourceOptions.series[salesIndex] = salesArray[salesIndex+1];
                }
                chart = new Highcharts.Chart(salesSourceOptions);
                
                engSourceOptions.xAxis.categories = sourceArray;
                for (var engIndex = 0; engIndex < engArray.length-1; engIndex++){
                    engSourceOptions.series[engIndex] = engArray[engIndex+1];
                }
                chart = new Highcharts.Chart(engSourceOptions);
                
                csmSourceOptions.xAxis.categories = sourceArray;
                for (var csmIndex = 0; csmIndex < csmArray.length-1; csmIndex++){
                    csmSourceOptions.series[csmIndex] = csmArray[csmIndex+1];
                }
                chart = new Highcharts.Chart(csmSourceOptions);
                
                internsSourceOptions.xAxis.categories = sourceArray;
                for (var internsIndex = 0; internsIndex < internsArray.length-1; internsIndex++){
                    internsSourceOptions.series[internsIndex] = internsArray[internsIndex+1];
                }
                //Uncomment line below to draw chart for Interns By Source stats
                //chart = new Highcharts.Chart(internsSourceOptions);
                                
                //Setting up the parameters for the charts displaying Conversion Rates By Stage
                var chartData = new Object();

                Object.defineProperty(chartData, "name", { value: "Month"});
                Object.defineProperty(chartData, "data", { value: stageCategoriesArray});
                
                salesArray = [];
                engArray = [];
                csmArray = [];
                internsArray = [];
                
                salesArray.push(chartData);
                engArray.push(chartData);
                csmArray.push(chartData);
                internsArray.push(chartData);
                for(var a=0; a< uniqueDates.length; a++){
                    chartData = new Object();
                    chartData.name = uniqueDates[a];
                    chartData.data = salesByStageRatio[a];
                    salesArray.push(chartData);
                    
                    chartData = new Object();
                    chartData.name = uniqueDates[a];
                    chartData.data = engByStageRatio[a];
                    engArray.push(chartData);
                    
                    chartData = new Object();
                    chartData.name = uniqueDates[a];
                    chartData.data = csmByStageRatio[a];
                    csmArray.push(chartData);
                    
                    chartData = new Object();
                    chartData.name = uniqueDates[a];
                    chartData.data = internsByStageRatio[a];
                    internsArray.push(chartData);
                }
                
                var salesStageOptions = {  
                    chart: {
                        renderTo: 'salesContainerByStage',
                        type: 'column',
                        marginRight: 130,
                        marginBottom: 75
                    },
                    title: {
                        text: 'Sales By Stage',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: [],
                        labels: {
                            padding: 100
                        },
                        
                    },
                    yAxis: {
                        title: {
                            text: 'Rate, %'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                this.x +': '+ this.y.toFixed(2)+' %';
                        },
                        crosshairs: [true, true]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                formatter: function() {
                                    if (this.y>0){
                                        return '<br/>'+this.y.toFixed(2)+'%';
                                    } else {
                                        return '';
                                    }
                                
                                },
                                enabled: true
                            }
                        }
                    },
                    series: []
                }
                
                var engStageOptions = {   
                    chart: {
                        renderTo: 'engContainerByStage',
                        type: 'column',
                        marginRight: 130,
                        marginBottom: 75
                    },
                    title: {
                        text: 'Engineering By Stage',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: [],
                        labels: {
                            padding: 100
                        },
                        
                    },
                    yAxis: {
                        title: {
                            text: 'Rate, %'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                this.x +': '+ this.y.toFixed(2)+' %';
                        },
                        crosshairs: [true, true]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                formatter: function() {
                                    if (this.y>0){
                                        return '<br/>'+this.y.toFixed(2)+'%';
                                    } else {
                                        return '';
                                    }
                                
                                },
                                enabled: true
                            }
                        }
                    },
                    series: []
                }
                
                var csmStageOptions = { 
                    chart: {
                        renderTo: 'csmContainerByStage',
                        type: 'column',
                        marginRight: 130,
                        marginBottom: 75
                    },
                    title: {
                        text: 'CSM By Stage',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: [],
                        labels: {
                            padding: 100
                        },
                        
                    },
                    yAxis: {
                        title: {
                            text: 'Rate, %'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                this.x +': '+ this.y.toFixed(2)+' %';
                        },
                        crosshairs: [true, true]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                formatter: function() {
                                    if (this.y>0){
                                        return '<br/>'+this.y.toFixed(2)+'%';
                                    } else {
                                        return '';
                                    }
                                
                                },
                                enabled: true
                            }
                        }
                    },
                    series: []
                }
                
                var internsStageOptions = {  
                    chart: {
                        renderTo: 'internsContainerByStage',
                        type: 'column',
                        marginRight: 130,
                        marginBottom: 75
                    },
                    title: {
                        text: 'Interns By Stage',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: [],
                        labels: {
                            padding: 100
                        },
                        
                    },
                    yAxis: {
                        title: {
                            text: 'Rate, %'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        formatter: function() {
                                return '<b>'+ this.series.name +'</b><br/>'+
                                this.x +': '+ this.y.toFixed(2)+' %';
                        },
                        crosshairs: [true, true]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                    plotOptions: {
                        series: {
                            dataLabels: {
                                formatter: function() {
                                    if (this.y>0){
                                        return '<br/>'+this.y.toFixed(2)+'%';
                                    } else {
                                        return '';
                                    }
                                
                                },
                                enabled: true
                            }
                        }
                    },
                    series: []
                }
                
                salesStageOptions.xAxis.categories = stageCategoriesArray;
                for (var salesIndex = 0; salesIndex < salesArray.length-1; salesIndex++){
                    salesStageOptions.series[salesIndex] = salesArray[salesIndex+1];
                }
                chart = new Highcharts.Chart(salesStageOptions);
                
                engStageOptions.xAxis.categories = stageCategoriesArray;
                for (var engIndex = 0; engIndex < engArray.length-1; engIndex++){
                    engStageOptions.series[engIndex] = engArray[engIndex+1];
                }
                chart = new Highcharts.Chart(engStageOptions);
                
                csmStageOptions.xAxis.categories = stageCategoriesArray;
                for (var csmIndex = 0; csmIndex < csmArray.length-1; csmIndex++){
                    csmStageOptions.series[csmIndex] = csmArray[csmIndex+1];
                }
                chart = new Highcharts.Chart(csmStageOptions);
                
                internsStageOptions.xAxis.categories = stageCategoriesArray;
                for (var internsIndex = 0; internsIndex < internsArray.length-1; internsIndex++){
                    internsStageOptions.series[internsIndex] = internsArray[internsIndex+1];
                }
                //Uncomment line below to draw chart for Interns By Stage stats
                //chart = new Highcharts.Chart(internsStageOptions);
            }
        });
        </script>

    </head>
    <body>
        <form action="../php/dbManager.php" method="post">
            <table class="menuTable">
                <td class="menuTD">
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
                <td class="menuTD">
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
        </form>
        <table id="chartTable">
            <tr id="rowBySource">
                <td id="salesContainerBySource"></td>
                <td id="engContainerBySource"></td>
                <td id="csmContainerBySource"></td>
                <td id="internsContainerBySource"></td>
            </tr>
            <tr id="rowByStage">
                <td id="salesContainerByStage"></td>
                <td id="engContainerByStage"></td>
                <td id="csmContainerByStage"></td>
                <td id="internsContainerByStage"></td>
            </tr>
        </table>
    </body>
</html>