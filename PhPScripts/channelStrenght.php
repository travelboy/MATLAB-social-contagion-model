<?php
	$user="Liverald";
	$completeurl = "http://ws.audioscrobbler.com/2.0/?method=user.getfriends&user=".$user."&api_key=403871b9b9e0c5f0b063df6a9266323c";
	$friendsList = simplexml_load_file($completeurl);

	$nFriends=$friendsList->friends->attributes()->total;
	
	echo "Channel Strenght: <br/> <br/>";
	
	$currentUser=$friendsList->friends->user;
/*	
	for($i=-1; $i<$nFriends; $i++){
		if($i==-1)
			echo "0 ";
		else{
			$useri=$currentUser[$i]->name;
			$completeurl = "http://ws.audioscrobbler.com/2.0/?method=tasteometer.compare&type1=user&type2=user&value1=".$user."&value2=".$useri."&api_key=403871b9b9e0c5f0b063df6a9266323c";
			$channelStrenght = simplexml_load_file($completeurl);
			echo $channelStrenght->comparison->result->score . " ";
		}	
	}
*/
	for($i=-1; $i<$nFriends; $i++){
		if($i==-1)
			$useri=$user;
		else
			$useri=$currentUser[$i]->name;
		for($j=-1; $j<$nFriends; $j++){
			if($i==$j){
				echo "0 ";
			}
			else{
				if($j==-1){
					$userj=$user;
				}
				else{
					$userj=$currentUser[$j]->name;
				}
				$completeurl = "http://ws.audioscrobbler.com/2.0/?method=tasteometer.compare&type1=user&type2=user&value1=".$useri."&value2=".$userj."&api_key=403871b9b9e0c5f0b063df6a9266323c";
				$channelStrenght = simplexml_load_file($completeurl);
				echo $channelStrenght->comparison->result->score . " ";
			}
		}
		echo "<br/>";
	}
?>
