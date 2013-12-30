<?php
namespace Hpexpi\Graphs\Dijkstra;
/**
 * the DijkstraNode: a node in its DijkstraContext-specific role
 * Created by Herman Peeren, December 2013
 *
 */

use BuildingBlocks\Contextual\Role;

class Node extends Role
{
	private $distance_to_origin;
	private $previous;
	private $rolePlayer;
	private $context;

	public function __construct($context, $node)
	{
		$this->context = $context;
		$this->rolePlayer = $node;
		// todo: register node at context
	}

	public function getUnvisitedNeighbours()
	{
		// return array of dijkstranodes
	}

	public function touch()
	{

	}

}