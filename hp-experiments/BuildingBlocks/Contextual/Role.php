<?php
namespace BuildingBlocks\Contextual;
/**
 * Role class
 * Created by Herman Peeren, December 2013
 *
 */

use Gear;

class Role extends Gear
{
	private $rolePlayer;

	public function __construct($rolePlayer, $context)
	{
		$this->rolePlayer = $rolePlayer;
		parent::__construct($context);
	}

}