<?php
	function cnt($print)
	{
		//opens countlog.txt to read the number of hits
		$datei1 = fopen("countlog.txt","r");
		$count = fgets($datei1,1000);
		fclose($datei1);
		$count=$count + 1 ;

		// opens countlog.txt to change new hit number
		$datei1 = fopen("countlog.txt","w");
		fwrite($datei1, $count);
		fclose($datei1);

		if($print == 'yes'){
		echo $count;}
	}

	function cntpost($print)
	{
		//opens countlog.txt to read the number of hits
		$datei1 = fopen("postlog.txt","r");
		$count = fgets($datei1,1000);
		fclose($datei1);
		$count=$count + 1 ;

		// opens countlog.txt to change new hit number
		$datei1 = fopen("postlog.txt","w");
		fwrite($datei1, $count);
		fclose($datei1);

		if($print == 'yes'){
			echo $count;
		}
	}
?>