dci-lab
=======

experiments using DCI (Data-Context-Interaction)

My implementation differs from the "official" DCI implementation, so that a Role and a RolePlayer form a new object in the context.
It is not the original RolePlayer-object, just temporary enhanced by role-methods, like is normally done in DCI, but a new object (consisting of a
Role-part and a RolePlayer-part). For an actor will not be taken to court for murder when having played Macbeth. Neither is the Macbeth-role
responsible for this low deed: the Role is just an abstraction, a class, not a concrete object. I will try to show my implementation is better, but to avoid confusion: *this is not DCI!*

A Dijkstra-implementation in PHP
--------------------------------
We have a DijkstraNode-role, which is the context-specific behaviour (and state) that will be played by a node.
The new objects are called "dijkstranodes", which is not just a "role-object", but a role played by a roleplayer
(which is exactly the same as a roleplayer who plays a role). Within the context there is no "roleplayer an sich",
only the roleplayers in their roles (= the roles as played by the roleplayers).