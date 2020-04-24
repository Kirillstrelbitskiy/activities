<?php
	$start_date = "21.04.2020";
	$date = new DateTime($start_date);

	echo "__ Date __ e m h</br>";

	while($date->format('d.m.Y') != date('d.m.Y')){	
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

		echo $str_date . " " . $e . " " . $m . " " . $h . "</br>";

		$date->modify('+1 day');
	}
?>
