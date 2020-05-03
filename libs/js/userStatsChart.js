$.ajax({
   url : '../libs/php/controllers/userStats.php',
   type : 'GET',
   success : (data) => {

       data = JSON.parse(data);
       var signupDate = [];
       var nb = [];
       data.forEach( (val) => {
           signupDate.unshift(val.signup_date);
           nb.unshift(val.nb);
       });

       var chartData = {
           labels: signupDate,
           datasets: [{
               label: 'Nombre de nouveaux clients',
               backgroundColor: 'rgba(73,226,255,0.25)',
               borderColor: '#46d5f1',
               hoverBackgroundColor: '#CCCCCC',
               hoverBorderColor: '#666666',
               data: nb
           }]
       };

       var ctx = document.getElementById('userStatsChart').getContext('2d');
       var chart = new Chart(ctx, {

           type: 'line',

           data: chartData,

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
