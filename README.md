dci-lab
=======

DCI (Data-Context-Interaction) in PHP

hp-experiments
--------------
My own experiments using contexts, roles and roleplayers in PHP. Please see the README.md in that subdirectory.

php-dci-libs
------------
Some other implementations of DCI in PHP:

* Fatty: originally for Laravel. Uses closure object binding (in PHP 5.4). See http://kirkbushell.me/data-context-interaction-for-php/. Code on https://github.com/kirkbushell/fatty.
* CoreDCI: can be used in PHP 5.3 (no traits). A method-injection PHP-implementation from 2010 using naming conventions like r*Rolename*Actions-classes. Used in http://code.google.com/p/waxphp/. See http://code.google.com/p/php-coredci/wiki/UsingCoreDCI
* the "reverse wrapper" (object wraps the role rather than the role wrapping the object), which results in methods of a role being injected in a data object (with examples in PHP 5.3 and using traits). See https://github.com/mbrowne/dci-php. Discussion: https://groups.google.com/d/msg/object-composition/YDKfrGuLXDo/pRirNWtks4oJ


Herman Peeren

last modified 2013-12-29


