<?php
/**
 * File:  Photo.php
 * Creation Date: 29/12/2016
 * description:
 *
 * @author: canals
 */

namespace photobox\models;


class Comment extends \Illuminate\Database\Eloquent\Model {
    
    protected $table ='photobox_comment';
    protected $primaryKey='id';
    
    public function photo () {
        
        return $this->belongsTo('\photobox\models\Photo', 'p_id' );
    }
    
 
}