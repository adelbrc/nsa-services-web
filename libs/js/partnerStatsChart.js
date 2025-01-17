$.ajax({
   url : '../libs/php/controllers/partnerStats.php', // my php file
   type : 'GET', // type of the HTTP request
   success : (data) => {

       data = JSON.parse(data);
       var addDate = [];
       var nb = [];
       data.forEach( (val) => {
           addDate.unshift(val.add_date);
           nb.unshift(val.nb);
       });

       var chartData = {
           labels: addDate,
           datasets: [{
               label: 'Nombre de nouveaux partenaires',
               backgroundColor: 'rgba(73,226,255,0.25)',
               borderColor: '#46d5f1',
               hoverBackgroundColor: '#CCCCCC',
               hoverBorderColor: '#666666',
               data: nb
           }]
       };

       var ctx = document.getElementById('partnerStatsChart').getContext('2d');
       var chart = new Chart(ctx, {
           // The type of chart we want to create
           type: 'line',

           // The data for our dataset
           data: chartData,

           // Configuration options go here
           options: {
               scales: {
                 xAxes: [ {
                   display: true,
                   scaleLabel: {
                     scaleSteps: 1,
                     display: true,
                     labelString: 'Date'
                   },
                 } ],
                 yAxes: [ {
                   display: true,
                   scaleLabel: {
                     display: true,
                     labelString: 'Nombre'
                   },
                   ticks: {
                     min: 0,
                     stepSize: 10
                   }
                 }]
               }
           }
       });
   }
});
