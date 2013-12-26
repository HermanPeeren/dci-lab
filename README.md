dci-lab
=======

experiments using DCI (Data-Context-Interaction)

My basic idea that differs from the "official" DCI is that a Role and a RolePlayer form a new object in the context.
It is not the original RolePlayer-object, just temporary enhanced by role-methods, but a new object (consisting of a
Role-part and a RolePlayer-part).

A Dijkstra-implementation in PHP
--------------------------------
We have a DijkstraNode-role, which is the context-specific behaviour (and state) that will be played by a node.
The new objects are called "dijkstranodes", which is not just a "role-object", but a role plaued by a roleplayer
(which is exactly the same as a roleplayer who plays a role). Within the context there is no "roleplayer an sich",
only the roleplayers in their roles (= the roles as played by the roleplayers).