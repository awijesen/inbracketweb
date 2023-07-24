<?php header("Cache-Control: no-cache"); 
date_default_timezone_set('Australia/Darwin');
$actualtime=date("Y-m-d", time());
echo $actualtime;

$today_ = date("l");
echo $today_;

if($today_ == 'Sunday') {
  $backCount = '-6 day';
} else if($today_ == 'Saturday'){
  $backCount = '-5 day';
} else if($today_ == 'Friday'){
  $backCount = '-4 day';
} else if($today_ == 'Thursday'){
  $backCount = '-3 day';
} else if($today_ == 'Wednesday'){
  $backCount = '-2 day';
} else if($today_ == 'Tuesday'){
  $backCount = '-1 day';
} else {
  $backCount = 0;
}

echo $backCount."</bt>";
$toDate = date('Y-m-d',(strtotime ( $backCount , strtotime ( $actualtime) ) ));

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Document</title>
</head>

<body>

  <?php
  require(__DIR__ . '/../dbconnect/db.php');
  // $con = new mysqli('localhost','root','','test');
  $query = $conn->query("select 
  ord.ShipDay,
  count(distinct(ord.SalesOrderNumber)) as 'ordCount'
  from GRW_INB_SALES_ORDERS ord
  where ord.ProcessedDate between '".$toDate."' and '".$actualtime."'
  group by ord.ShipDay;
  ");

  foreach ($query as $data) {
    switch ($data["ShipDay"]) {
      case '1 Monday':
        $dt = 'M';
        break;
      case '1 Monday Fortnightly':
        $dt = 'MF';
        break;
      case '2 Tuesday':
        $dt = 'T';
        break;
      case '2 Tuesday Fortnightly':
        $dt = 'TF';
        break;
      case '3 Wednesday':
        $dt = 'W';
        break;
      case '3 Wednesday Fortnightly':
        $dt = 'WF';
        break;
      case '4 Thursday':
        $dt = 'TH';
        break;
      case '4 Thursday Fortnightly':
        $dt = 'THF';
        break;
      case '5 Friday':
        $dt = 'F';
        break;
      case '5 Friday Fortnightly':
        $dt = 'FF';
        break;
      case 'Special':
        $dt = 'SP';
        break;
    }

    $month[] = $dt;
    $amount[] = $data['ordCount'];
    
  }

  ?>


  <div style="width: 250px;">
    <canvas id="myChart"></canvas>
  </div>

  <script>
    // === include 'setup' then 'config' above ===
    const labels = <?php echo json_encode($month) ?>;
    const data = {
      labels: labels,
      datasets: [{
        label: 'Order count',
        data: <?php echo json_encode($amount) ?>,
        backgroundColor: [
          '#2c7be5',
          '#2c7be5',
          '#2c7be5',
          '#2c7be5',
          '#2c7be5',
          '#2c7be5',
          '#2c7be5'
        ],
        borderColor: [
          'rgb(255, 99, 132)',
          'rgb(255, 159, 64)',
          'rgb(255, 205, 86)',
          'rgb(75, 192, 192)',
          'rgb(54, 162, 235)',
          'rgb(153, 102, 255)',
          'rgb(201, 203, 207)'
        ],
        borderWidth: 0
      }]
    };

    const config = {
      type: 'bar',
      data: data,
      options: {
        plugins: {
            legend: {
                display: false,
                // labels: {
                //     color: 'rgb(255, 99, 132)'
                // }
            }
        },
        borderRadius: 4,
        borderSkipped: true,
        // barPercentage: 0.5,
        barThickness: 6,
        maxBarThickness: 8,
        // minBarLength: 2,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      },
    };

    var myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
  </script>

</body>

</html>