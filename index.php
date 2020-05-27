<?php
/**
 * File:  index.php
 * Creation Date: 29/12/2016
 * description:
 *
 * @author: canals
 */

require_once 'vendor/autoload.php' ;

$app = new \Slim\Slim();
\photobox\utils\Eloquent::init('src/conf.ini');

$app->get('/photos(/)', function() {

    (new \photobox\control\PhotoController)->getListPhotos() ;
})->name('photos') ;


$app->get('/photos/:id', function($id) {

    (new \photobox\control\PhotoController)->getPhoto($id) ;
})->name('photo') ;

$app->get('/photos/:id/categorie', function($id) {

    (new \photobox\control\PhotoController)->getPhotoCategorie($id) ;
})->name('photo2cat') ;

$app->get('/categories(/)', function() {

    (new \photobox\control\PhotoController)->getListCategories() ;
})->name('categories');

$app->get('/categories/:id/photos', function($id) {

    (new \photobox\control\PhotoController)->getListPhotos($id) ;
})->name('cat2photos');


$app->get('/photos/:id/comments', function($id) {

    (new \photobox\control\PhotoController)->getComments($id) ;
})->name('photo2comments');

$app->post('/photos/:id/comments', function($id) {

    (new \photobox\control\PhotoController)->addComment($id) ;

});

$app->options('/photos/:id/comments', function($id) {

    (new \photobox\control\PhotoController)->outputResponse(200, null) ;
}

) ;

$app->run();


