$.ajax({
   url : '../libs/php/controllers/orderStats.php', // my php file
   type : 'GET', // type of the HTTP request
   success : (data) => {

       data = JSON.parse(data);
       var orderDate = [];
       var nb = [];
       data.forEach( (val) => {
           orderDate.unshift(val.order_date);
           nb.unshift(val.nb);
           console.log(val);
       });

       var chartData = {
           labels: orderDate,
           datasets: [{
               label: 'Nombre de commandes / jour',
               backgroundColor: 'rgba(73,226,255,0.25)',
               borderColor: '#46d5f1',
               hoverBackgroundColor: '#CCCCCC',
               hoverBorderColor: '#666666',
               data: nb
           }]
       };

       var ctx = document.getElementById('orderStatsChart').getContext('2d');
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
