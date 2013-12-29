<?php
/**
 * the Dijkstra context in which the dijkstranode-roles are played
 * Created by Herman Peeren, December 2013
 * 
 */

class DijkstraContext
{
	private $q;
	private $dijkstraGraph;

	public function __construct($graph)
	{
		$this->q = new DijkstraQueue();

		// the graph is a collection of nodes, each defining their own neighbours. Now, let them ALL play the role of a DijkstraNode.
		$this->dijkstraGraph = new DijkstraGraph($graph, $this);
	}

}