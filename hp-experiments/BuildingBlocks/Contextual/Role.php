<?php
namespace BuildingBlocks\Contextual;
/**
 * Role class
 * In this implementation a Role is a class from which an object in a Context is instantiated.
 * A Role has a context, that serves as a container to reach other objects in the Context.
 * A Role can be instantiated without a RolePlayer: then we have an autonomous Role.
 * A Role can also be instantiated with multiple  RolePlayers. In that case $rolePlayer is an array of RolePlayers.
 * Created by Herman Peeren, December 2013
 *
 */

class Role
{
	private $rolePlayer;
	private $context;

	public function __construct(Context $context, $rolePlayer=null)
	{
		$this->context = $context;
		$this->rolePlayer = $rolePlayer;
	}

}