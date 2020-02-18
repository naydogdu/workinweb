<?php

class Ticket extends Eloquent {
	
	public function ticketable() {	
		return $this->morphTo();	 
	}
}