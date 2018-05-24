<?php

class GetSession{
	function GetSessionString(){
		if(isset($_COOKIE["US-K"]))
			return $_COOKIE["US-K"];
	}
}

?>