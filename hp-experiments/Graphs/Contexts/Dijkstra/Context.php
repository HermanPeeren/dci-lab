<?php
namespace Hpexpi\Graphs\Dijkstra;
/**
 * the Dijkstra context in which the dijkstranode-roles are played
 * Created by Herman Peeren, December 2013
 * 
 */

use BuildingBlocks\Contextual\Context as BasicContext;

class Context extends BasicContext
{
	private $q;
	private $graph;

	public function __construct($graph)//TODO: not the graph but the mapping must be given
	{
		$this->q = new DijkstraQueue();

		// the graph is a collection of nodes, each defining their own neighbours. Now, let them ALL play the role of a DijkstraNode.
		$this->graph = new Graph( $this, $graph);
	}

	/**
	 * Convenience method: to call the shortestpath algorithm without knowing on which object to call it.
	 *
	 */
	public function getShortestPath($origin_id, $destination_id)
	{
		return $this->graph->getShortestPath($origin_id, $destination_id);
	}
}