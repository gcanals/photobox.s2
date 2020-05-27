<?php
/**
 * File:  PhotoController.php
 * Creation Date: 29/12/2016
 * description:
 *
 * @author: canals
 */

namespace photobox\control;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use photobox\models\Photo;
use photobox\models\Categorie;
use photobox\models\Comment;

class PhotoController {

    protected $app;
    protected $req;
    protected $res;

    public function __construct()
    {
        $this->app = \Slim\Slim::getInstance();
        $this->req = $this->app->request;
        $this->res = $this->app->response;
    }

    private function setResponseStatus($s)
    {
        $this->res->setStatus($s);
    }

    private function setHeader($header, $value)
    {
        $this->res->headers->set($header, $value);
    }

    private function json_response()
    {
        $this->res->headers->set('Content-Type', 'application/json; charset=utf-8');


    }

    public function cors_options( Array $methods, Array $headers) {
        $org = $this->req->headers->get('Origin') ;
        $this->res->headers->set('Access-Control-Allow-Origin', $org);
        $this->res->headers->set('Access-Control-Allow-Methods', implode(',',$methods));
        $this->res->headers->set('Access-Control-Allow-Headers', implode(',',$headers));
        $this->res->headers->set('Access-Control-Allow-Credentials', 'true');
    }

    public function outputResponse($status, $jsondata) {
        $this->setResponseStatus($status);
        $this->json_response();
        $this->cors_options(['GET', 'POST'], ['Content-Type', 'Authorization', 'X-Requested-With']);
        echo $jsondata;
    }

    public function getListPhotos($cat=null) {

        if ($cat) {
            try {

                Categorie::where('id', '=', $cat)->firstOrFail();

            } catch (ModelNotFoundException $e) {
                $this->outputResponse(404, json_encode(['error' => "invalid cat id : $cat"]));
                return;
            }
        }

        $q = Photo::Select('id','titre', 'file' );

        if (! is_null($cat)) {
            $q = $q->where('cat_id', '=', $cat);
        }

        $count = $q->count();
        
        $offset = ( $this->req->get('offset') ? $this->app->request->get('offset') : 0);
        $size = ( $this->req->get('size') ? $this->app->request->get('size') : 10);
        //$size_next = $size ;
        $q = $q->OrderBy('created_at', 'DESC')->take($size)->skip($offset) ;

        $list =[];
        foreach( $q->get() as $p ) {
            $photo = $p->toArray();
            $photo['thumbnail'] = ['href'=> $this->req->getRootUri() . '/img/small/'.$p->file ];
            $photo['original'] = ['href'=> $this->req->getRootUri() . '/img/large/'.$p->file ];
            $link = [ 'self'=> ['href'=>$this->app->urlFor('photo', ['id' => $p->id])]];
            array_push($list, [ 'photo' => $photo, 'links' => $link]);

        };

        if (is_null($cat)) {
            $url_list = $this->app->urlFor('photos', []);
        } else {
            $url_list = $this->app->urlFor('cat2photos', ['id'=>$cat]);
        }

        $offset_prev = $offset-$size; if ($offset_prev < 0) $offset_prev=0 ;
        $offset_next = $offset+$size; if ($offset_next >= $count) $offset_next = $offset;
        //if ($offset_next+$size > $count) $size_next = $count-$offset_next ;
        //$offset_last = round( $count / $size )* $size;
        $offset_last = intdiv($count,$size) * $size;
        $size_last = $count % $size ;



        
        $links = [
            'first' => ['href' => $url_list."?offset=0&size=$size"],
            'prev'  => ['href' => $url_list."?offset=$offset_prev&size=$size"],
            'next'  => ['href' => $url_list."?offset=$offset_next&size=$size"],
            'last'  => ['href' => $url_list."?offset=$offset_last&size=$size_last"],
        ];
        
        $json_data = json_encode( [ 'photos'=> $list, 
                                    'links' => $links]);
        
        $this->outputResponse(200, $json_data);
        
    }

    public function getPhoto($id){

        try {
            $photo = Photo::select('id','titre', 'file', 'descr', 'format', 'type', 'size', 'width', 'height')
                 ->where('id', '=', $id)->firstOrFail();
            
            $photo_data = $photo->toArray();
            $photo_data['url'] = ['href' => $this->req->getRootUri() . '/img/large/'.$photo->file];
            
            $links = ['categorie' => ['href'=>$this->app->urlFor('photo2cat', ['id'=>$id])],
                       'comments' => ['href'=>$this->app->urlFor('photo2comments', ['id'=>$id])]
                    ];
            $json_data = json_encode([ 'photo' => $photo_data, 'links'=> $links]);
            $this->outputResponse(200, $json_data);
            
            
        } catch (ModelNotFoundException $e) {
            $this->outputResponse(404, json_encode(['error' => "invalid photo id : $id"]));
        }
        
    }
    
    public function getListCategories() {

        $listCateg =Categorie::orderBy('nom')->get();


        $list=[];
        foreach ($listCateg as $categ) {

            $c=$categ->toArray();
            $l=['photos'=> ['href'=>$this->app->urlFor('cat2photos', ['id'=>$c['id']])]];
            array_push($list, ['categorie'=>$c, 'links'=>$l]);
        }
        $this->outputResponse(200, json_encode(['categories'=>$list]));
    }

    public function getComments($id) {


        try {
            $p=Photo::where('id', '=', $id)
                ->firstOrFail();
            $list=[];
            $comments = $p->comments()
                        ->select('id','titre', 'pseudo', 'content', 'created_at' )
                        ->orderBy('created_at', 'DESC')
                        ->get();
            foreach ( $comments as $c) {
                $comment=$c->toArray();
                $comment['date'] = $c->created_at->format('d/m/Y');
                unset ($comment['created_at']);
                array_push($list, $comment);
            }

            $json_data = json_encode(['comments' => $list]);
            $this->outputResponse(200, $json_data);

        } catch (ModelNotFoundException $e) {
            $this->outputResponse(404, json_encode(['error' => "invalid photo id : $id"]));
        }
    }

    public function addComment( $id ) {

        try {
            $p=Photo::where('id', '=', $id)->firstOrFail();

            $contentType = $this->app->request->getContentType();
            $data = null;
            if (is_int(stripos($contentType, 'application/json' ) ) ){
                $data = json_decode( $this->app->request->getBody(), true );
            } else {
                $data = $this->app->request->post();
            }
            
            if (empty($data)) {
                $this->outputResponse(400, json_encode(['error'=>"missing post data : all",
                                                                'content-type'=>$contentType,
                                                                'data'=>$this->app->request->getBody()]));
                return ;
            };
            if (!isset($data['titre']))  {
                $this->outputResponse(400, json_encode(['error'=>"missing post data : titre"]));
                return ;
            };
            if (!isset($data['pseudo']))  {
                $this->outputResponse(400, json_encode(['error'=>"missing post data : pseudo"]));
                return ;
            };
            if (!isset($data['content']))  {
                $this->outputResponse(400, json_encode(['error'=>"missing post data : content"]));
                return ;
            };
            
            $comment = new Comment;
            $comment->titre = filter_var($data['titre'], FILTER_SANITIZE_STRING);
            $comment->pseudo = filter_var($data['pseudo'], FILTER_SANITIZE_STRING);
            $comment->content = filter_var($data['content'], FILTER_SANITIZE_STRING);

            $p->comments()->save( $comment );

            $c = $comment->toArray() ;
            unset ($c['updated_at']);
            unset($c['p_id']);unset($c['c_id']);
            $c['date'] = $comment->created_at->format('d/m/Y');
            unset ($c['created_at']);

            $this->outputResponse(201, json_encode(['comment' => $c ]));
            
            
        } catch (ModelNotFoundException $e) {
            $this->outputResponse(404, json_encode(['error' => "invalid photo id : $id"]));
        }
    }

}