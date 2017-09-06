<?php
	$query = $_GET['query'];

	$data = array(
				"query"=>$query,
				"suggestions"=>array(
									array("value"=>"Ukraine Bavariya","data"=>51),
									array("value"=>"Italy","data"=>53)
									)
				);
	
	echo json_encode($data);
	
	/*
	echo '
	{
    "query": "Unit",
    "suggestions": [
        { "value": "United Arab Emirates", "data": "AE" },
        { "value": "United Kingdom",       "data": "UK" },
        { "value": "United States",        "data": "US" }
    ]
}
	';
	*/