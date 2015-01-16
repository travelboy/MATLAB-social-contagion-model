<?php
	$user="Liverald";
	
	$completeurl = "http://ws.audioscrobbler.com/2.0/?method=user.getfriends&user=".$user."&limit=100&api_key=403871b9b9e0c5f0b063df6a9266323c";
	$friendsList = simplexml_load_file($completeurl);
	$nFriends=$friendsList->friends->attributes()->total;
	
	$agents=$friendsList->friends->user;
	
	for($i=1; $i<96; $i++){

		if($i==-1)
			$currentUser=$user;
		else
			$currentUser=$agents[$i]->name;

		$completeurl = "http://ws.audioscrobbler.com/2.0/?method=user.gettopartists&user=".$currentUser."&api_key=403871b9b9e0c5f0b063df6a9266323c";
		$topArtists = simplexml_load_file($completeurl);

		$nArtists=$topArtists->topartists->attributes()->total;
	
		if($nArtists>50)
			$nArtists=50;

		$currentArtist=$topArtists->topartists->artist;

		$nRocks=0;
		$nJazz=0;
		$nPop=0;
		$nElectronic=0;
		$nRelated=0;

		for($i = 0; $i < $nArtists; $i++) {
			$name=$currentArtist[$i]->name;
			$currentArtistName=str_replace(" ","%20",$name);
			$completeurl = "http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=".$currentArtistName."&api_key=403871b9b9e0c5f0b063df6a9266323c";
			$currentArtistGenere = simplexml_load_file($completeurl);
			$alreadyCounted=false;
			foreach($currentArtistGenere->artist->tags->tag as $tag){
				switch ($tag->name) {
	   				case "rock":
						$nRocks++;
						if(!$alreadyCounted){
							$alreadyCounted=true;
							$nRelated++;
						}
					    break;
					case "jazz":
						$nJazz++;
						if(!$alreadyCounted){
							$alreadyCounted=true;
							$nRelated++;
						}
		   				break;
					case "pop":
						$nPop++;
						if(!$alreadyCounted){
							$alreadyCounted=true;
							$nRelated++;
						}
						break;
					case "electronic":
						$nElectronic++;
						if(!$alreadyCounted){
							$alreadyCounted=true;
							$nRelated++;
						}
						break;
				}
			}
		}
	
		$opinionRock=$nRocks/$nRelated;
		$opinionJazz=$nJazz/$nRelated;
		$opinionPop=$nPop/$nRelated;
		$opinionElectronic=$nElectronic/$nRelated;
	
		echo $opinionRock .";". $opinionJazz .";". $opinionJazz .";". $opinionPop .";". $opinionElectronic."<br/>";
	}
?>

