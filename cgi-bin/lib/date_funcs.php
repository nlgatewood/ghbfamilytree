<?php

/*------------------------------------------------------------
 * format_date() - Take the passed year, month, date and format
 *						 it according to the specified format
 *------------------------------------------------------------*/
function format_date($year,$month,$day,$format) {

	$date_string = '';
		
	//If everything is null, send back the N/A string
	if($year == null && $month == null && $day == null){

		$date_string = 'N/A';
	}
	//Else, format the date
	else{
		//If a date year, month, or day doesn't exist, initialize it
		if($year == null){

			$year = 0;
		}
		
		if($month == null){

			$month = 0;
		}

		if($day == null){

			$day = 0;
		}

		$month = str_pad($month, 2, '0', STR_PAD_LEFT);
		$day = sprintf('%02d', $day);
		$year = sprintf('%04d', $year);
	
		if($format == 'MM/DD/YYYY'){

			$date_string = $month."/".$day."/".$year;
		}
		elseif($format == 'text'){

			$months_text = get_months();
			$date_string = $months_text[$month]." ".$day.", ".$year; 
		}
	}	

	return $date_string;
}

/*------------------------------------------------------------
 * get_months() -- Return an array of month number, abbreviation
 *						 key=>'month#', value='abbreviation'
 *------------------------------------------------------------*/
function get_months(){

	$months_array = array('01'	=> 'Jan',
						  		 '02'	=> 'Feb',
								 '03'	=> 'Mar',
						  		 '04'	=> 'Apr',
						  		 '05'	=> 'May',
						  		 '06'	=> 'Jun',
						  		 '07'	=> 'Jul',
						  		 '08'	=> 'Aug',
						  		 '09'	=> 'Sep',
						  		 '10'	=> 'Oct',
						  		 '11'	=> 'Nov',
						  		 '12'	=> 'Dec');
		
	return $months_array;
}

?>
