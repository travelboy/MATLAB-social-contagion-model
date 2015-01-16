<?php
    /* create a dom document with encoding utf8 */
    $domtree = new DOMDocument('1.0', 'UTF-8');

    /* create the root element of the xml tree */
    $xmlRoot = $domtree-> createElementNS("http://www.gexf.net/1.2draft","gexf");
    $xmlRootVersion = $domtree->createAttribute('version');
    $xmlRootVersion->value = '1.2';


    /* append it to the document created */
    $xmlRoot->appendChild($xmlRootVersion);
    $xmlRoot = $domtree->appendChild($xmlRoot);
    
    $graph=$domtree->createElement("graph");
    $graphMode = $domtree->createAttribute('mode');
    $graphMode->value = 'static';
    $graph->appendChild($graphMode);
    $graphType=$domtree->createAttribute('defaultedgetype');
    $graphType->value="directed";
	$graph->appendChild($graphType);
    $graph=$xmlRoot->appendChild($graph);

   	$nodes = $domtree->createElement("nodes");
    $nodes = $graph->appendChild($nodes);

	$edges = $domtree->createElement("edges");
  	$edges = $graph->appendChild($edges);

	/*Fetch the data*/
	$currentUser="Liverald";
	$completeurl ="http://ws.audioscrobbler.com/2.0/?method=user.getinfo&user=".$currentUser."&api_key=403871b9b9e0c5f0b063df6a9266323c";
	$xml = simplexml_load_file($completeurl);
	/*In*/
	$currentNode=$domtree->createElement("node");
	$userId=$domtree->createAttribute('id');
	$userId->value=$xml->user->id;
	$currentNode->appendChild($userId);
	$userLabel=$domtree->createAttribute('label');
	$userLabel->value=$xml->user->name;
	$currentNode->appendChild($userLabel);
	$currentNode=$nodes->appendChild($currentNode);
	
	$completeurl = "http://ws.audioscrobbler.com/2.0/?method=user.getfriends&user=".$currentUser."&api_key=403871b9b9e0c5f0b063df6a9266323c";
	$xml = simplexml_load_file($completeurl);

	$nFriends=$xml->friends->attributes()->total;

	$friends = $xml->friends->user;

	for($i = 0; $i < $nFriends; $i++) {
		$currentNode=$domtree->createElement("node");
		$friendId=$domtree->createAttribute("id");
		$friendId->value=$friends[$i]->id;
		$currentNode->appendChild($friendId);
		$friendLabel=$domtree->createAttribute("label");
		$friendLabel->value=$friends[$i]->name;
		$currentNode->appendChild($friendLabel);
		$currentNode=$nodes->appendChild($currentNode);	
		
		$currentEdge=$domtree->createElement("edge");
		$edgeId=$domtree->createAttribute("id");
		$edgeId->value=$i;
		$currentEdge->appendChild($edgeId);
		$sourceId=$domtree->createAttribute("source");
		$sourceId->value=$userId->value;
		$currentEdge->appendChild($sourceId);
		$targetId=$domtree->createAttribute("target");
		$targetId->value=$friends[$i]->id;
		$currentEdge->appendChild($targetId);
		$currentEdge=$edges->appendChild($currentEdge);	
	}
    echo $domtree->saveXML();
?>
