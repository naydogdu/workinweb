<?php 

class Upload extends Eloquent {

	protected $table = 'uploads';

	protected $fillable = array('url', 'name', 'size', 'type');

	public $timestamps = false;

	public function profils() 
	{
		return $this->belongsToMany('Profil', 'upload_profil', 'upload_id', 'profil_id');
	}

	public function profil()
	{
		return $this->belongsTo('Profil', 'avatar_id');
	}
	public function tickets()
    {
        return $this->morphMany('Ticket', 'ticketable');
    }
}