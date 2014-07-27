<?php

if (config('dispatch.debug')) {

	ORM::configure('mysql:host=localhost;dbname=zmjdc');
	ORM::configure('username', 'root');
	ORM::configure('password', 'root');

	/** enable cache */
	ORM::configure('caching', true);
} else {
	ORM::configure('mysql:host=localhost;dbname=xxx');
	ORM::configure('username', 'xxx');
	ORM::configure('password', 'xxx');

	/** enable cache */
	ORM::configure('caching', true);
}
