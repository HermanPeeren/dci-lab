using Roles and RolePlayers in a Context
====================================================
My implementation differs from the "official" DCI implementation. I instantiate a Role, using a RolePlayer.
It is *not* the original RolePlayer-object, temporary enhanced by role-methods, like is normally done in DCI,
but a new object (instantiating the Role played by the RolePlayer). For an actor will not be taken to court for murder when having played Macbeth. Neither is the Macbeth-role
responsible for this low deed: the Role is just an abstraction, a class, not a concrete object. I will try to show why my implementation is better, but to avoid confusion: **this is not DCI!**

I just call this:
contextual encapsulation
------------------------
Which describes what I am doing. Maybe even more clear than "Data-Context-Interaction". I use an instantiation of a Role, in which a concrete RolePlayer is injected. In the official DCI this is called a "wrapper" and seen as wrong, as it would lead to "object schizophrenia".

See (recurring) discussions about this on the DCI-mailinglist, a.o:
* PHP wrapper-based implementation that allows nested, recursive contexts: https://groups.google.com/forum/#!topic/object-composition/g4BMSdluuC8
* The end of injectionless DCI: https://groups.google.com/forum/#!topic/object-composition/MBvBMZzjW_M
* Roles and RolePlayers: https://groups.google.com/forum/#!topic/object-composition/YDKfrGuLXDo

Autonomous Roles and Roles with multiple RolePlayers
---------------
What I don't like in some of the current DCI-examples is, that context-specific state can only be implemented by context-properties,
that are not bound to the objects in the context, even if they would fit better there. That is because in the "official"
DCI, Roles can only have behaviour, no state. During a Dijkstra algorithm for instance: a node can be visited or not.
Or can have distances to the origin. I'd say that those properties belong to the node-objects in their roles in the context,
not just somewhere as some property in the context. Also, in current DCI there is no specific object that has a Context
but is not being played as a Role.


At first I made a basic object to act in a Context.
A Role was extended from a that basic object and is played by a RolePlayer.
Another way to look at those basic objects is as Roles that have no RolePlayer; I called the
"autonomous Roles" . Then Roles are simply all objects in a Context, some of which are not played by a RolePlayer.
In my Dijkstra-implementation the Queue is such a basic object (a context-specific object, but not a Role),
and dijkstranodes are Roles played by nodes.

 There is a third reason why I instantiate Roles: as is a.o. stated in http://www.artima.com/articles/dci_vision.html:
 "Object-orientation pushed us into a world where we had to split up the algorithm and distribute it across several objects".
 However, if a Role is played by domain-objects then we still distribute the behaviour (what the system does) over the data-objects
 (what the system is). We still divide behaviour in the roles among the objects. The only place where we can
 keep the algorithm as a whole is at the system-level: as context-methods. That is: procedures that operate on data (which is the
 "procedural programming" paradigm). Nothing necessarily wrong with that: in a way DCI is a hybrid paradigm of class oriented and procedural
  programming. One of the key points of Object Thinking however is that data is meaningless without behaviour and behaviour
 is always on specific data; the two are coupled. I liked that so very much when I started doing Simula by the end of the seventies:
 to look for the smallest building blocks of unseparable data/behaviour.

 What the system does, the script, the algorithm, might not fit into an existing object.
 Or might even use several objects as RolePlayers (like a fake horse, played by two performers).
 Also see section 8.2.4 "A Special Case: One-to-Many Mapping of Object Roles to Objects" in the Lean Architecture book.
 Now we get a little bit different picture:
 Roles that are instantiated as objects, played by zero or more RolePlayers. All objects in a Context are then called Roles.
 From within a Role you can interact with all other Roles in that Context. When a Role is instantiated without a RolePlayer I call it an autonomous Role.


A Dijkstra-implementation in PHP
--------------------------------
We have a DijkstraNode-role, which is the context-specific behaviour (and state) that will be played by a node.
The new objects are called "dijkstranodes", which is not just a "role-object", but a role played by a specific roleplayer
(which is exactly the same as a roleplayer who plays a role). Within the context there is no "roleplayer an sich",
only the "roleplayers in their roles" (== the "roles as played by the roleplayers").

Besides the dijstranodes we have another object in the Dijkstra-context: the queue of "touched" but yet unvisited dijkstranodes.
With "touched" I mean: they have allready  been given a distance from the origin (and a "previous" dijkstranode), but they have not been visited themselves yet.

Visiting means:
 1. touch all unvisited neighbours
 2. remove this visited dijkstranode from the queue

Touching means:
 1. compute the distance from origin to the touched neighbour via the current dijkstranode
 2. when this distance is smaller than the distance in that dijkstranode: change the distance and set the current dijkstrnode as previous of that touched dijkstranode
 3. add the touched dijkstranode to the queue (if not there allready)

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

last modified 2013-12-30