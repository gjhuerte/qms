<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primary = 'id';
    public $timestamps = true;

    public function rules()
    {
    	return array(
    		'Name' => 'required|string|min:5|max:100|unique:categories,name'
    	);
    }

    public function updateRules()
    {
    	$name = $this->name;
    	return array(
    		'Name' => 'required|string|min:5|max:100|unique:categories,name,'. $name . ",name"
    	);
    }
}
