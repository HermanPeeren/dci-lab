<?php
/**
 * General file to run the whole thing
 * Created by Herman Peeren, December 2013
 * 
 */

$graph = new GraphManhattan();
$origin_id = 'A';
$destination_id = 'Z';
$context = new DijkstraContext($graph);
$path = $context->dijkstraGraph->getShortestPath($origin_id, $destination_id);
print_r($path);