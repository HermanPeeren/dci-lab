<?php
/**
 * the DijkstraGraph: a collection of ALL dijkstranodes
 * Another implementation would be to only create dijkstranodes when needed (lazy instantiation)
 * Created by Herman Peeren, December 2013
 * 
 */

class DijkstraGraph
{
	private $context; // this must be part of a general Role class
	private $dijkstraGraph;

	/**
	 * constructor
	 *
	 */
	public function __construct($graph, $context)
	{
		$this->context = $context;

		$this->dijkstraGraph = array();
		// the graph is a collection of nodes, each defining their own neighbours. Now, let them ALL play the role of a DijkstraNode.
		foreach ($graph->getNodes() as $node)
		{
			$this->dijkstraGraph[] = new DijkstraNode($node, $context);//? do I need the id of the nodes to index them???
		}
	}

	/**
	 * the Dijkstra algorithm itself
	 *
	 */
	public function getShortestPath($origin_id, $destination_id)
	{
		$context = $this->context;

		// initialisation of origin and destination as DijkstraNodes; The Dijkstranodes have the same id as the rolePlayers
		// N.B.: would this give a problem if we have different types of objects as roleplayers, like with the stars and circles example?
		// or how is this with the same RolePlayer that is used several times?
		$origin = $this->find($origin_id);
		$destination = $this->find($destination_id);

		// initialisation of queue: touch the origin
		$context->q->add($origin);

		//start the engines: work until the queue is empty or the destination is reached
		while (($current = $context->q->getNext()) && ($current != $destination) //no: destination should be visited too, at last!
		{
			foreach ($current->getUnvisitedNeighbours() as $neighbour)
			{
				$neighbour->touch();
			}
		}

		// walk back the shortest path
		$path = array();
		$current = $destination;
		while (($current != origin) && (!is_null($current->previous)))
		{
			array_unshift($path, $current->id);
		}

        // return the ids of nodes with shortest path
		return $path;
	}
	/**
	 * retieve a DijkstraNode, given its id
	 *
	 */
	private function find($id)
	{
		foreach ($this->$dijkstraGraph as $dijkstranode)
		{
			if ($dijkstranode->id == $id) return $dijkstranode;
		}
	}

}