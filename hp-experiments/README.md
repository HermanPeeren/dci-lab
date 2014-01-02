using Roles and RolePlayers in a Context
====================================================
My implementation differs from the "official" DCI implementation. I instantiate a Role, using a RolePlayer.
In my implementation objects in a context are *not* the original RolePlayer-objects, temporary enhanced by role-methods, like is normally done in DCI,
but a new object (instantiating the Role played by the RolePlayer). For an actor will not be taken to court for murder when having played Macbeth. Neither is the Macbeth-role
responsible for this low deed: the Role is just an abstraction, a class, not a concrete object. I will try to show why my implementation is better, but to avoid confusion: **this is not DCI!**

I just call this:
contextual encapsulation
------------------------
Maybe as label even more clear than "Data-Context-Interaction". I use an instantiation of a Role, in which a concrete RolePlayer is injected. In the official DCI this is called a "wrapper" and seen as wrong, as it would lead to "object schizophrenia".
However, in my implementation of the Dijkstra algorithm with a context, seen as an "oracle", I didn't experience that schizophrenic problem...

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

The algorithm as a system-method, injecting context objects and observers
-------------------------------------------------------------------------
There are 3 ways to implement an algorithm in a context:

1. as a **system-method of that context**. In this way all interaction of the context-objects is in this context method.
The context is the "subject" of this method: you call DijkstraContext.ShortestPathmethod() or MoneyTansferContext.TransferMethod().
It has similarities to procedural programming: an algorithm acting upon data. Not: the objects interacting themselves.

2. as a **method of a context-object**. Like in the money transfer examples, where transfer() is a method of the source account.
In the same way ShortestPath() can be a method of the graph in the Dijkstra context. If the object now wants to interact with another object in
that context (for instance with the destination account), then that other object has to be known by the acting object (the "subject").
With the money transfer example that is done by injecting the destination account as a parameter of the method. With the Dijkstra implementation
you can make shortestPath() a method of the graph in the Dijkstra context. In that method you'll need interaction with a queue:
that can be a part of the graph in the Dijkstra context or must be injected into the graph-object, or at least in that
shortestPath()-method. A method can be to use the **context as a container** and injecting that container into each object
that needs interaction with other objects in that context. All objects of that context are then available in the object in which the container is injected.
I experimented with it, using the context as a property in every Role. Whenever a new object is made in the context, it has to be
"registered" at that context-object.

3. using **observers**: all objects only send messages and interact with messages that fly around in the context. Ihis is the most
decoupled implementation, honouring the "tell, don't ask" principle. The context has a dispatcher to trigger the objects
that act upon the messages. The effect however is, that the algorithm will be scattered over the objects. If you would
for instance use this for a Dijkstra implementation, the shortestPath() method would send a message "can anybody trigger the first
node to be visited", a queue might send a message "this is the next node in me; do with it whatever you want", a node might react "that's me,
I'll mark myself as visited and send a message to my neighbours to update their distance to the origin and trigger the queue to get the next
node to visit after that", the neigbours can pick up that message saying "hey that's a message for me, I'll compare that distance
to what I have now and if smaller will update my distance and let the queue know about it", etc. In this implementation
the algorithm doesn't have to know anything about who picks up the message and do a next thing. In my opinion, this is the most
pure OO implementation, but the algorithm is indeed scattered over the objects. I don't see it as a disadvantage: each object
is easy to understand and easy to test in isolation. Obviously it is contrary to the basic ideas of DCI.

A Dijkstra-implementation in PHP
--------------------------------
In my implementation I use the second way described above: shortestPath() is a method of the graph in the Dijkstra-context.
The queue is a part of the graph in the Dijkstra context. The nodes are also part of the graph, so no other objects need to be injected
in the graph-object or its methods in order to interact with them.

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