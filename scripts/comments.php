<?php
/**
 * File:  import.php
 * Creation Date: 04/01/2017
 * description:
 *
 * @author: canals
 */

require_once '../vendor/autoload.php' ;
use photobox\models\Photo;
use photobox\models\Comment;

\photobox\utils\Eloquent::init('../src/conf.ini');
$faker = Faker\Factory::create('fr_FR');

/*
foreach (Photo::all() as $p) {

    $nbc = rand(0,4);
    for ($i=0; $i<= $nbc; $i++) {

        $c = new Comment();
        $c->pseudo = $faker->userName;
        $c->content = $faker->text(300);
        $c->titre = $faker->sentence(5);
        $c->p_id = $p->id;
        
        $c->save();
    };

}
*/

/*
 * updating timestamps
 */

foreach (Comment::all() as $c) {
    $days = rand(0, 365);
    $hours = rand(0,24);
    $mins = rand(0,60);
    $c->created_at=$c->created_at->sub(new DateInterval('P'.$days.'DT'.$hours.'H'.$mins.'M'));
    $c->save();
}