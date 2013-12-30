using Roles and RolePlayers in a Context
====================================================
My implementation differs from the "official" DCI implementation. I implement a Role, using a RolePlayer.
It is not the original RolePlayer-object, just temporary enhanced by role-methods, like is normally done in DCI,
but a new object (implementing the Role plyed by the RolePlayer). For an actor will not be taken to court for murder when having played Macbeth. Neither is the Macbeth-role
responsible for this low deed: the Role is just an abstraction, a class, not a concrete object. I will try to show why my implementation is better, but to avoid confusion: **this is not DCI!**

I just call this:
contextual encapsulation
------------------------
Which describes what I am doing. Maybe even more clear than "data-context-interaction". I use an implementation of a Role, in which a concrete RolePlayer is injected. In the official DCI this is called a "wrapper" and seen as wrong, as it would lead to "object schizophrenia".

See (recurring) discussions about this on the DCI-mailinglist, a.o:
* PHP wrapper-based implementation that allows nested, recursive contexts: https://groups.google.com/forum/#!topic/object-composition/g4BMSdluuC8
* The end of injectionless DCI: https://groups.google.com/forum/#!topic/object-composition/MBvBMZzjW_M
* Roles and RolePlayers: https://groups.google.com/forum/#!topic/object-composition/YDKfrGuLXDo

Gears and Roles
---------------
What I don't like in what I see in current DCI-implementations is, that context-specific state is often solved by primitive datastructures
like arrays. That is because in the "official" DCI there can only be behaviour in Roles, no state. There also is no specific object that has a Context but is not being played as a Role.
So I made a basic object to act in a Context. It would elsewhere be called an "actor" but that term is too confusing. I also don't
like a class called "object". So I took a word that has no specific meaning in a programming context yet, as far as I know: Gear. A Gear is a basic object with a Context.
 A Role is extended from a Gear and has a(or better: is played by a) RolePlayer.

A Dijkstra-implementation in PHP
--------------------------------
We have a DijkstraNode-role, which is the context-specific behaviour (and state) that will be played by a node.
The new objects are called "dijkstranodes", which is not just a "role-object", but a role played by a specific roleplayer
(which is exactly the same as a roleplayer who plays a role). Within the context there is no "roleplayer an sich",
only the "roleplayers in their roles" (== the "roles as played by the roleplayers").

Besides the dijstranodes we have another object in the Dijkstra-context: the queue of "touched" but yet unvisited dijkstranodes.
With "touched" I mean: they have allready  been given a distance from the origin (and a "previous" dijkstranode), but they have not been visited themselves yet.

Visiting means:
 a. touch all unvisited neighbours
 b. remove this visited dijkstranode from the queue

Touching means:
 a. compute the distance from origin to the touched neighbour via the current dijkstranode
 b. when this distance is smaller than the distance in that dijkstranode: change the distance and set the current dijkstrnode as previous of that touched dijkstranode
 c. add the touched dijkstranode to the queue (if not there allready)

 Next current dijkstranode is the dijkstranode with minimum distance to origin in queue. That dijkstranode is given by the queue. The queue has an interface with 3 methods:
 add a dijkstranode, remove a dijkstranode and give the next dijkstranode with a minimum value for distance to origin. The queue is an object that is only important within the context.
 But it is not a role, for there is no roleplayer. The queue could be implemented as a sub-context. The main consideration not to do that here is that
 that the queue does not represent a use case (a much used term in the Lean Architecture book). In DCI  a use case is defined as:
 "A use case is a description of a potential series of interactions between program and a user, which lead the user towards a business goal".
 As I don't see a direct business goal for a user here, I didn't implement the queue as a context. So, in this implementation the dijkstraqueue
 is a context specific object that interacts with the other context objects (in this case: instantiated dijkstranodes).

 In the above I talk about "dijkstranodes", not just "nodes". That is because it is about the nodes *in their role*, not the nodes "an sich".
 Within the context the nodes are only considered within their roles, as players of that specific role. The "node an sich" is only visible *within* the role it is playing,
 not outside it, not in the context in general.

Herman Peeren

last modified 2013-12-29