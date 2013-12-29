<?php
/**
 * the DijkstraNode: a node in its DijkstraContext-specific role
 * Created by Herman Peeren, December 2013
 *
 */

class DijkstraNode
{
	private $distance_to_origin;
	private $previous;
	private $rolePlayer;
	private $context;

	public function __construct($node, $context)
	{
		$this->context = $context;
		$this->rolePlayer = $node;
	}

	public function getUnvisitedNeighbours()
	{
		// return array of dijkstranodes
	}

	public function touch()
	{

	}

}