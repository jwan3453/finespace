<?php
namespace App\Models;
use Zizaco\Entrust\EntrustRole;

use DB;

class Role extends EntrustRole
{
    protected $table = 'roles';

    private $name = '';
    private $display_name = '';
    private $description = '';
    private $created_at = '';
    private $updated_at = '';

    function __construct()
    {
    	
    }

    public function createAdmin($Arr = array())
    {
    	// dd($Arr['name']);
    	DB::insert('insert into roles (name, display_name, description, created_at, updated_at) values ("'.$Arr['name'].'", "'.$this->display_name.'", "'.$this->description.'" , "'.date('Y-m-d H:i:s').'" ,"'.date('Y-m-d H:i:s').'")');

    	return true;
    }

}