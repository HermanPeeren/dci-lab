<?php
namespace Hpexpi\Graphs\Dijkstra;
/**
 * An instance of this class is the queue in a DijkstraContext.
 * It is a collection of unvisited but touched dijkstranodes, ordered by distance_to_origin.
 * Simple implementation, keeping the ordering when adding another dijkstranode, so minimum is always the first.
 * Faster implementation would be by using a Fibonacci-queue.
 * Created by Herman Peeren, December 2013
 * 
 */

use BuildingBlocks\Contextual\Role;

class Queue extends Role
{
    private $q = array();

    public function add(Node $dijkstranode)
    {
	    //$this->q->add($dijkstranode); // insert a not-yet existing dijkstranode while keeping the ordering
    }

    public function remove(Node $dijkstranode)
    {
	    //$this->q->remove($dijkstranode);
    }

    public function getNext()
    {
	    // Retrieve the dijkstranode with minimum distance to origin from $this->q (= first in queue)
	    //return $minimumdijkstranode;
    }

}