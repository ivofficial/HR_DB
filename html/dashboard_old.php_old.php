<!DOCTYPE html>

<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="/style/importStyles.css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="js/lodash.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {

            var dataArray = [];
            var roleArray = ['Sales', 'Engineering', 'CSM', 'Interns'];
            var sourceArray = ['Referral', 'Angel List', 'Career Site', 'Outreach', 'Hired', 'Gogohire', 'HireUp', 'Conferences'];
            var stageArray = ['All Applicants', 'Phone Screen','Onsite', 'Final Onsite', 'Offer', 'Accept', 'Decline'];
            var monthYearArray = [];
            var uniqueDates = [];
            var salesBySource = [];
            var salesBySourceRatio = [];
            var salesBySourceDate = [];
            var conversionBySource = [];
            var sourceArray = [];
            var applicants = 0;
            var hires = 0;
            
            $.ajax({
                type: "GET",
                url:"data.csv",
                dataType: "text",
                success: function(data) {processData(data);}
            });
            

            
            function processData(allText) {
                var allTextLines = allText.split(/\r\n|\n/);
                var headers = allTextLines[0].split(',');
                var lines = [];

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
                
                uniqueDates = _.uniq(monthYearArray);

                //alert(dataArray[0][6]);
                
                for (var j=0; j<uniqueDates.length; j++) {
                    var tmpArray = [];
                    applicants = 0;
                    hires = 0;
                    for (var i =0; i<dataArray.length; i++) {
                        if(dataArray[i][0].indexOf(uniqueDates[j])>=0 ) {
                            if (dataArray[i][3].indexOf(roleArray[0])>=0) {

                                if (dataArray[i][5].indexOf(stageArray[0])>=0){
                                    applicants+= dataArray[i][6];
                                } else if (dataArray[i][5].indexOf(stageArray[4])>=0){
                                    hires += dataArray[i][6];
                                    //alert("ratio: "+(hires/applicants));
                                    if (applicants !== 0) {
                                        tmpArray.push((hires/applicants)*1000);
                                    } else {
                                        tmpArray.push(0);
                                    }
                                    applicants = 0;
                                    hires = 0;
                                }
                            }
                        }
                       salesBySourceRatio.push(tmpArray);
                    }
                    
                }
                //alert(salesBySourceRatio[0][0]);
                //alert("sales: "+salesBySourceRatio[0].length);
                var str = "";
                var num = 0.00;
                for (var p=0; p<salesBySourceRatio[0].length; p++){
                    str += salesBySourceRatio[0][p];
                    num += salesBySourceRatio[0][p];
                }
                //alert(str);
                //alert(num);
                
                
            
                var options {
                    chart: {
                        renderTo: 'container',
                        type: 'column',
                        marginRight: 130,
                        marginBottom: 25
                    },
                    title: {
                        text: 'Conversion Rates By Source',
                        x: -20 //center
                    },
                    subtitle: {
                        text: '',
                        x: -20
                    },
                    xAxis: {
                        categories: sourceArray
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
                                this.x +': '+ this.y;
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -10,
                        y: 100,
                        borderWidth: 0
                    },
                    series: []
                };

                $.getJSON("data.json", function(json) {
                    options.xAxis.categories = json[0]['data'];
                    options.series[0] = json[1];
                    options.series[1] = json[2];
                    chart = new Highcharts.Chart(options);
                });
                
                
                
                
                
                
                
                
//                $(function () {
//                
//                    $('#container').highcharts({
//                        chart: {
//                            type: 'column'
//                        },
//                        title: {
//                            text: 'Monthly Average Rainfall'
//                        },
//                        subtitle: {
//                            text: 'Source: WorldClimate.com'
//                        },
//                        xAxis: {
//                            categories: [
//                                'Referral',
//                                'Angel List',
//                                'Career Site',
//                                'Outreach',
//                                'Hired',
//                                'Gogohire',
//                                'HireUp',
//                                'Conferences'
//                            ],
//                            crosshair: true
//                        },
//                        yAxis: {
//                            min: 0,
//                            title: {
//                                text: 'Rainfall (mm)'
//                            }
//                        },
//                        tooltip: {
//                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
//                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
//                                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
//                            footerFormat: '</table>',
//                            shared: true,
//                            useHTML: true
//                        },
//                        plotOptions: {
//                            column: {
//                                pointPadding: 0.2,
//                                borderWidth: 0
//                            }
//                        },
////                        series: [{
////                            name: 'Tokyo',
////                            data: salesBySourceRatio[0]
////                        }, {
////                            name: 'New York',
////                            data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]
////
////                        }, {
////                            name: 'London',
////                            data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]
////
////                        }, {
////                            name: 'Berlin',
////                            data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]
////
////                        }]
//                        series: [];
//
//                    });
//                });
            
            }
            

            
            
            
            
            
            
            

        });
        
        
        
        
        
        
    </script>
<script type="text/javascript" src="canvasjs.min.js"></script>
</head>
<body>
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</body>
</html>
