<?php
	$start_date = "21.04.2020";
	$date = new DateTime($start_date);

    $data = [];

    $pos = 0;
	while($date->format('d.m.Y') <= date('d.m.Y')){	
		$str_date = $date->format('d.m.Y');
		
		$url ="https://raw.githubusercontent.com/Kirillstrelbitskiy/activities/master/" . $str_date;
		$file = fopen($url, 'r');

		$e = 0; $m = 0; $h = 0;
		while($problem = fgets($file)){
			$type = $problem[0];
			if($type == 'e')
				$e++;
			if($type == 'm')
				$m++;
			if($type == 'h')
				$h++;
        }
        $data[$pos]->Date = $date->format('d.m');
        $data[$pos]->e = $e;
        $data[$pos]->m = $m;
        $data[$pos]->h = $h;

        $date->modify('+1 day');
        $pos++;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activities - Chart</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
    <div id="container" style="width:100%; height:70vh; margin-top: 15vh"></div>
</body>


<script> 
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.theme = {
            colors: ['#d9534f', '#f0ad4e', '#5cb85c'],
        };
        // Apply the theme
        Highcharts.setOptions(Highcharts.theme);

        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Solved problems<br>' + '<?php echo $start_date . " - " . date('d.m.Y'); ?>'
            },
            xAxis: {
                categories: [<?php foreach($data as $item) echo "'" . $item->Date . "', "; ?>]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total problems solved'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'gray'
                    }
                }
            },
            legend: {
                align: 'center',
                verticalAlign: 'top',
                y: 50,
                floating: true,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: false
                    }
                }
            },
            series: [
                {
                    name: 'Hard',
                    data: [<?php foreach($data as $item) echo $item->h . ", "; ?>]
                },
                {
                    name: 'Medium',
                    data: [<?php foreach($data as $item) echo $item->m . ", "; ?>]
                },
                {
                    name: 'Easy',
                    data: [<?php foreach($data as $item) echo $item->e . ", "; ?>]
                },
            ]
        });
    });
</script>
</html>