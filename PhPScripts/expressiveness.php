<?php
	echo "Expressiveness: <br/> <br/>";
	$user="Liverald";
	$completeurl = "http://ws.audioscrobbler.com/2.0/?method=user.getfriends&user=".$user."&limit=100&api_key=403871b9b9e0c5f0b063df6a9266323c";
	$friendsList = simplexml_load_file($completeurl);

	$nFriends=$friendsList->friends->attributes()->total;
	
	$completeurl = "http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=".$user."&from=1352872800%20&to=%201355464800%20&api_key=403871b9b9e0c5f0b063df6a9266323c";
	$recentTracks = simplexml_load_file($completeurl);
	echo $recentTracks->recenttracks->attributes()->total."<br/>";

	foreach($friendsList->friends->user as $currentUser){
		$completeurl = "http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=".$currentUser->name."&from=1352872800%20&to=%201355464800%20&api_key=403871b9b9e0c5f0b063df6a9266323c";
		$recentTracks = simplexml_load_file($completeurl);
		if($recentTracks!=NULL)
			echo $recentTracks->recenttracks->attributes()->total."<br/>";
		else
//			echo $currentUser->name."<br/>";
			echo "-1 <br/>"
	
?>

