<?php
namespace BuildingBlocks\Contextual;
/**
 * Gear: class for a basic object with a Context. When played by a RolePlayer it is extended as Role.
 * Via the Context other Gears/Roles can be reached.
 * Created by Herman Peeren, December 2013
 *
 */

use Context;

class Gear
{
	private $context;

	public function __construct(Context $context)
	{
		$this->context = $context;
	}

}