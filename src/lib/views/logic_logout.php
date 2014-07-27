<?php

function logic_logout() {
	auth_out();
	redirect('/');
}
