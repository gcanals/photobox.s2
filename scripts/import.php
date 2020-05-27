<?php
/**
 * File:  import.php
 * Creation Date: 04/01/2017
 * description:
 *
 * @author: canals
 */

require_once '../vendor/autoload.php' ;

\photobox\utils\Eloquent::init('../src/conf.ini');
$faker = Faker\Factory::create('fr_FR');

//var_dump(gd_info());

if (! isset($argv[1])) {
    echo "missing args\n";
    exit(1);
}

if (! is_dir($argv[1])) {
    echo "source ${argv[1]} : not a directory\n";
    exit(1);
}

if (! is_dir($argv[2])) {
    echo "dest ${argv[2]} : not a directory\n";
    exit(1);
}

if (! is_dir($argv[2]."/large")) {
    echo "dest ${argv[2]}/large: not a directory\n";
    exit(1);
}

if (! is_dir($argv[2]."/small")) {
    echo "dest ${argv[2]}/small: not a directory\n";
    exit(1);
}

if (! isset($argv[3])) {
    echo "missing args : catégorie\n ";
    exit(1);
}



$dest_cat = intval($argv[3]);
$dest_large = $argv[2]."/large/" ;
$dest_small = $argv[2]."/small/" ;


$files = glob($argv[1].'/*.*');

foreach ($files as $path) {


    echo $path . "\n";
    $path_parts = pathinfo($path);
    $filename = $path_parts['filename'];
    $extension = $path_parts['extension'];
    //var_dump(exif_read_data($path));

    $img = new Imagick($path);
    $format = $img->getImageFormat();
    $type=$img->getImageMimeType();
    $size = $img->getImageLength();
    $width = $img->getImageWidth();
    $height=$img->getImageHeight();

    echo $filename ."\n";
    echo $extension ."\n";
    echo $format ."\n";
    echo $type ."\n";
    echo $size ."\n";
    echo $width ."\n";
    echo $height ."\n";
    $dest_file_name = uniqid('img_') . ".$extension";
    echo $dest_large.$dest_file_name."\n";
    echo "-------\n";

    $img->writeImage($dest_large.$dest_file_name);
    $img->thumbnailImage(400,0);
    $img->writeImage($dest_small.$dest_file_name);

    $phot = new \photobox\models\Photo();
    $phot->titre = $filename ;
    $phot->file = $dest_file_name;
    $phot->descr = $faker->text;
    $phot->format = $format;
    $phot->type = $type;
    $phot->size = $size;
    $phot->width=$width;
    $phot->height=$height;
    $phot->cat_id = $dest_cat;

    $phot->save();

    
}