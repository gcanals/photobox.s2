<?php
/**
 * File:  Photo.php
 * Creation Date: 29/12/2016
 * description:
 *
 * @author: canals
 */

namespace photobox\models;


class Categorie extends \Illuminate\Database\Eloquent\Model {
    
    protected $table ='photobox_categorie';
    protected $primaryKey='id';
    public $timestamps = false ;
    

    
    public function photos() {

        return $this->hasMany('\photobox\models\Photo', 'c_id');
    }

}