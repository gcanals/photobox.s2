<?php
/**
 * File:  Photo.php
 * Creation Date: 29/12/2016
 * description:
 *
 * @author: canals
 */

namespace photobox\models;


class Photo extends \Illuminate\Database\Eloquent\Model {
    
    protected $table ='photobox_photo';
    protected $primaryKey='id';
    
    public function categorie () {
        
        return $this->belongsTo('\photobox\models\Categorie', 'cat_id' );
    }
    
    public function comments() {

        return $this->hasMany('\photobox\models\Comment', 'p_id');
    }

}