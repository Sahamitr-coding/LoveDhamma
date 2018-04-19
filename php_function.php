<?php

	function notification_detail($n){ //get id for $n
		switch ($n) {
			case 1:
			//Register
				$detail = "just registered."
				break;
			case 2:
			//Reset password
				$detail = "just reset password."
				break;
			default:
				$detail = "not in any case.";
				break;
		}

		return $detail;
	}

?>