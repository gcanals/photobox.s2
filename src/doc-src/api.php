<?php
/**
 * File:  api.php
 * Creation Date: 12/11/2016
 * description:
 *
 * @author: canals
 */




/**
 * @apiGroup Categories
 * @apiName GetCategorie
 * @apiVersion 0.1.0
 *
 * @api {get} /categories  1. liste des catégories
 *
 * @apiDescription Accès à la liste des catégories
 * permet d'accéder à la représentation de la liste des catégories de photos
 * Retourne une représentation json de la liste, incluant un tableau de catégories
 * Chaque catégorie est décrite par son nom et sa description.
 *
 * Le résultat inclut un lien pour accéder à la liste des photos de cette catégorie.
 *
 *
 *
 * @apiSuccess (Succès : 200) {Array} categories le tableau de categories
 * @apiSuccess (Succès : 200) {Object} categorie une ressource catégorie
 * @apiSuccess (Succès : 200) {Number} categorie.id identifiant de la catégorie
 * @apiSuccess (Succès : 200) {String} categorie.nom Nom de la catégorie
 * @apiSuccess (Succès : 200) {String} categorie.descr Description de la catégorie
 * @apiSuccess (Succès : 200) {Object} links liens concernant la catégorie
 * @apiSuccess (Succès : 200) {Link}   links.photos lien vers la liste de photos de la catégorie
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *   {
 *      "categories": [
 *              { 
 *                  "categorie": {
 *                           "id": 5,
 *                          "nom": "chats",
 *                        "descr": "des photos de chats, quoi"
 *                  },
 *                  "links": {
 *                      "photos": { "href": "/photobox/categories/5/photos" }
 *                  }
 *              },
 *              {
 *                  "categorie": {
 *                          "id": 4,
 *                          "nom": "nature",
 *                        "descr": "la nature sous tous les angles"
 *                  },
 *                  "links": {
 *                      "photos": { "href": "/photobox/categories/4/photos" }
 *                  }
 *              }
 *      ]
 *  }
 *
 */



/**
 * @apiGroup Categories
 * @apiName GetPhotosCategorie
 * @apiVersion 0.1.0
 *
 * @api {get} /categories/id/photos  2. liste des photos d'une catégorie
 *
 * @apiDescription Accès à une liste de photos d'une catégorie donnée -
 * permet d'accéder à la liste des photos d'une catégorie. Retourne une représentation json contenant
 * un tableau de photos. Chaque photo est décrite par son titre, le nom du fichier, une url vers la photo en
 * petit et grand format. Chaque photo inclut un lien pour accéder à la ressource photo correspondante.
 *
 * Le résultat inclut des liens de pagination pour parcourir la liste.
 *
 * @apiParam {Number} id Identifiant unique de la catégorie
 *
 *
 * @apiSuccess (Succès : 200) {Array} Photos tableau des photos de la catégories
 * @apiSuccess (Succès : 200) {Object} photo la description d'une ressource photo
 * @apiSuccess (Succès : 200) {Number} photo.id identifiant de la photo
 * @apiSuccess (Succès : 200) {String} photo.titre Titre de la photo
 * @apiSuccess (Succès : 200) {String} photo.filfile nom de fichier de la photo
 * @apiSuccess (Succès : 200) {Url}    photo.thumbnail url de la photo, version vignette
 * @apiSuccess (Succès : 200) {Url}    photo.original url de la photo, version originale
 * @apiSuccess (Succès : 200) {Object} links liens de pagination dans la liste de photos
 * @apiSuccess (Succès : 200) {Uri}   links.first uri de la 1ère page de la liste
 * @apiSuccess (Succès : 200) {Uri}   links.last uri de la dernière page de la liste
 * @apiSuccess (Succès : 200) {Uri}   links.next uri de la  page suivante de la liste
 * @apiSuccess (Succès : 200) {Uri}   links.prev uri de la  page précédente de la liste
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *     {
 *       "photos" : [
 *        {
 *          "photo": {
 *               "id": 38,
 *               "titre": "hall-1929422_1920",
 *               "file": "img_586d389c6c4ae.jpg",
 *               "thumbnail": {
 *                   "href": "/photobox/img/small/img_586d389c6c4ae.jpg"
 *               },
 *                 "original": {
 *                  "href": "/photobox/img/large/img_586d389c6c4ae.jpg"
 *               }
 *          },
 *          "links": {
 *              "self": {
 *                   "href": "/photobox/photos/38"
 *              }
 *          }
 *        },
 *       {
 *          "photo": {
 *              "id": 37,
 *               "titre": "graffiti-966463_1920",
 *              "file": "img_586d389c153b2.jpg",
 *              "thumbnail": {
 *                  "href": "/photobox/img/small/img_586d389c153b2.jpg"
 *              },
 *              "original": {
 *                  "href": "/photobox/img/large/img_586d389c153b2.jpg"
 *              }
 *          },
 *          "links": {
 *              "self": {
 *                  "href": "/photobox/photos/37"
 *              }
 *          }
 *      }
 *     ],
 *     "links": {
 *          "first": {
 *                   "href": "/photobox/categories/2/photos?offset=0&size=10"
 *              },
 *          "prev": {
 *                  "href": "/photobox/categories/2/photos?offset=0&size=10"
 *              },
 *          "next": {
 *                  "href": "/photobox/categories/2/photos?offset=10&size=10"
 *          },
 *          "last": {
 *                  "href": "/photobox/categories/2/photos?offset=20&size=7"
 *          }
 *     }
 *  }
 *
 * @apiError (Erreur : 404) CategorieNotFound Categorie inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error" : "invalid cat id : 1234"
 *     }
 */




/**
 * @apiGroup Photos
 * @apiName GetPhotos
 * @apiVersion 0.1.0
 *
 * @api {get} /photos[/?offset=o&size=s]  1. liste des photos, pagination
 *
 * @apiDescription Accès la liste de photos
 * permet d'accéder à la liste des photos. Retourne une représentation json contenant
 * un tableau de photos. Chaque photo est décrite par son titre, le nom du fichier, une url vers la photo en
 * petit et grand format. Chaque photo inclut un lien pour accéder à la ressource photo correspondante.
 *
 * Le résultat inclut des liens de pagination pour parcourir le résultat.
 *
 * @apiParam {Number} offset (optionnel) offset dans la liste des photos
 * @apiParam {Number} size (optionnel) nombre de photos retournées
 *
 *
 * @apiSuccess (Succès : 200) {Array} Photos tableau des photos
 * @apiSuccess (Succès : 200) {Object} photo la description d'une ressource photo
 * @apiSuccess (Succès : 200) {Number} photo.id identifiant de la photo
 * @apiSuccess (Succès : 200) {String} photo.titre Titre de la photo
 * @apiSuccess (Succès : 200) {String} photo.filfile nom de fichier de la photo
 * @apiSuccess (Succès : 200) {Url}    photo.thumbnail url de la photo, version vignette
 * @apiSuccess (Succès : 200) {Url}    photo.original url de la photo, version originale
 * @apiSuccess (Succès : 200) {Object} links liens de pagination dans la liste de photos
 * @apiSuccess (Succès : 200) {Uri}   links.first uri de la 1ère page de la liste
 * @apiSuccess (Succès : 200) {Uri}   links.last uri de la dernière page de la liste
 * @apiSuccess (Succès : 200) {Uri}   links.next uri de la  page suivante de la liste
 * @apiSuccess (Succès : 200) {Uri}   links.prev uri de la  page précédente de la liste
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *     {
 *       "photos" : [
 *        {
 *          "photo": {
 *               "id": 38,
 *               "titre": "hall-1929422_1920",
 *               "file": "img_586d389c6c4ae.jpg",
 *               "thumbnail": {
 *                   "href": "/photobox/img/small/img_586d389c6c4ae.jpg"
 *               },
 *                 "original": {
 *                  "href": "/photobox/img/large/img_586d389c6c4ae.jpg"
 *               }
 *          },
 *          "links": {
 *              "self": {
 *                   "href": "/photobox/photos/38"
 *              }
 *          }
 *        },
 *       {
 *          "photo": {
 *              "id": 37,
 *               "titre": "graffiti-966463_1920",
 *              "file": "img_586d389c153b2.jpg",
 *              "thumbnail": {
 *                  "href": "/photobox/img/small/img_586d389c153b2.jpg"
 *              },
 *              "original": {
 *                  "href": "/photobox/img/large/img_586d389c153b2.jpg"
 *              }
 *          },
 *          "links": {
 *              "self": {
 *                  "href": "/photobox/photos/37"
 *              }
 *          }
 *      }
 *     ],
 *     "links": {
 *          "first": {
 *                   "href": "/photobox/photos/?offset=0&size=10"
 *              },
 *          "prev": {
 *                  "href": "/photobox/photos/?offset=0&size=10"
 *              },
 *          "next": {
 *                  "href": "/photobox/photos/?offset=10&size=10"
 *          },
 *          "last": {
 *                  "href":"/photobox/photos/?offset=100&size=3"
 *          }
 *     }
 *  }
 *
 */


 /**
 * @apiGroup Photos
 * @apiName GetPhoto
 * @apiVersion 0.1.0
 *
 * @api {get} /photos/id/  2. détail d'une photo
 *
 * @apiDescription accès aux informations détaillées concernant une photo
 * Retourne une représentation json d'une photos. Laphoto est décrite par son titre,
 * le nom du fichier, une description et des informations sur l'image ;
 * une url vers l'image originale en formùat jpeg est incluse
 *
 * Le résultat inclut des liens pour accéder à la catégorie de l'image et aux commentaires
 * associés à la photo.
 *
 * @apiParam {Number} id Identifiant unique de la photo
 *
 *
 * @apiSuccess (Succès : 200) {Object} photo la description d'une ressource photo
 * @apiSuccess (Succès : 200) {Number} photo.id identifiant de la photo
 * @apiSuccess (Succès : 200) {String} photo.titre Titre de la photo
 * @apiSuccess (Succès : 200) {String} photo.descr description de la photo
 * @apiSuccess (Succès : 200) {String} photo.file nom de fichier de la photo
 * @apiSuccess (Succès : 200) {String} photo.format format de la photo (type MIME)
 * @apiSuccess (Succès : 200) {Number} photo.size taille de la photo (octets)
 * @apiSuccess (Succès : 200) {Number} photo.width largeur de la photo (pixels)
 * @apiSuccess (Succès : 200) {Number} photo.height hauteur de la photo (pixels)
 * @apiSuccess (Succès : 200) {Url}    photo.url url de la photo, version originale
 * @apiSuccess (Succès : 200) {Object} links liens assoxiés à la photo
 * @apiSuccess (Succès : 200) {Uri}   links.categorie lien vers la catégorie de la photo
 * @apiSuccess (Succès : 200) {Uri}   links.comments lien vers les commentaires de la photo
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *        {
 *          "photo": {
 *               "id": 38,
 *               "titre": "hall-1929422_1920",
 *               "file": "img_586d389c6c4ae.jpg",
 *               "descr": "Dolor odio consequatur expedita. Iusto sit molestiae accusantium delectus. Earum voluptatibus voluptate officiis id exercitationem. Quia temporibus asperiores enim optio quae.",
 *               "format": "JPEG",
 *               "type": "image/jpeg",
 *               "size": 152178,
 *               "width": 1280,
 *                "height": 720,
 *                "url": {
 *                  "href": "/photobox/img/large/img_586d389c6c4ae.jpg"
 *                }
 *          },
 *          "links": {
 *              "categorie": {
 *                 "href": "/photobox/photos/10/categorie"
 *              },
 *             "comments": {
 *                 "href": "/photobox/photos/10/comments"
 *             }
 *          }
 *        }
 *
 * @apiError (Erreur : 404) PhotoNotFound Photo inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error" : "invalid photo id : 1234"
 *     }
 */

/**
 * @apiGroup Photos
 * @apiName GetPhotoComments
 * @apiVersion 0.1.0
 *
 * @api {get} /photos/id/comments  3. liste des commentaires  pour une photo
 *
 * @apiDescription accès aux commentaires concernant une photo
 * Retourne une représentation json de la liste des commentaires concernant une photo ;
 * Chaque commentaire est décrit par un titre, un contenu, le psudo de l'auteur et une date d'ajout
 *
 *
 * @apiParam {Number} id Identifiant unique de la photo
 *
 *
 * @apiSuccess (Succès : 200) {Array} comments le tableau de commentaire
 * @apiSuccess (Succès : 200) {Object} comment une ressource commentaire
 * @apiSuccess (Succès : 200) {String} comment.titre Titre du commentaire
 * @apiSuccess (Succès : 200) {String} comment.content contenu du commentaire
 * @apiSuccess (Succès : 200) {String} comment.pseudo pseudo de l'auteur du commentaire
 * @apiSuccess (Succès : 200) {String} comment.date date d'ajout du commentaire
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *  {
 *      "comments": [
 *          {
 *              "id": 37,
 *              "titre": "Facilis corporis harum itaque impedit iste.",
 *              "pseudo": "margaux57",
 *              "content": "Velit et vitae sint similique aut quia placeat. Blanditiis ut soluta quis magni animi. Nisi unde laboriosam vel quis non quo beatae.\nSunt iure est minima et totam sint eum. Pariatur quod officia sint voluptas non. Dolores laudantium temporibus velit dolorem sit. Aut omnis repellat at velit.",
 *              "date": "30/11/2016"
 *          },
 *          {
 *              "id": 35,
 *              "titre": "Incidunt excepturi modi et commodi sed deserunt.",
 *              "pseudo": "bonnin.elise",
 *              "content": "Possimus nulla architecto fugit recusandae quo facilis tempora. Sed voluptate dicta et officia.\nVitae numquam omnis ut voluptas aut et consequatur illo. Asperiores nulla fugiat quia vero enim et quia. Esse quia voluptas numquam sunt et. Voluptatem necessitatibus qui consequatur dolorem.",
 *              "date": "13/09/2016"
 *          }
 *      ]
 *  }
 *
 * @apiError (Erreur : 404) PhotoNotFound Photo inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error" : "invalid photo id : 1234"
 *     }
 */

/**
 * @apiGroup Photos
 * @apiName AddPhotoComments
 * @apiVersion 0.1.0
 *
 * @api {post} /photos/id/comments  4. ajout de commentaire pour une photo
 *
 * @apiDescription ajout d'un commentaire concernant une photo
 * Les données relative au nouveau commentaire sont transmises en JSON
 * dans le body de la requête
 *
 * @apiParam {Number} id Identifiant unique de la photo
 * @apiParam {String} pseudo pseudo du visiteur ajoutant le commentaire
 * @apiParam {String} titre titre du commentaire
 * @apiParam {Number} content contenu du commentaire
 *
 * * @apiParamExample {request} exemple de paramètres
 *     {
 *       "titre"       : "sed fluctuat",
 *       "content"     : "nec mergitur, et laudade cum honoris causae, sinse, milia",
 *       "pseudo"      : "albert"
 *     }
 *
 * @apiExample Exemple de requête :
 *    POST /photos/106/comments HTTP/1.1
 *    Host: webetu.iutnc.univ-lorraine.fr
 *    Content-Type: application/json;charset=utf8
 *
 *    {
 *       "titre"       : "sed fluctuat",
 *       "content"     : "nec mergitur, et laudade cum honoris causae, sinse, milia",
 *       "pseudo"      : "albert"
 *     }
 *
 *
 * @apiSuccess (Succès : 201) {Object} comment une ressource commentaire
 * @apiSuccess (Succès : 201) {String} comment.titre Titre du commentaire
 * @apiSuccess (Succès : 201) {String} comment.content contenu du commentaire
 * @apiSuccess (Succès : 201) {String} comment.pseudo pseudo de l'auteur du commentaire
 * @apiSuccess (Succès : 201) {String} comment.date date d'ajout du commentaire
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *  HTTP/1.1 201 CREATED
 *
 *  {
 *      "comment": {
 *              "id": 37,
 *              "titre": "Facilis corporis harum itaque impedit iste.",
 *              "pseudo": "margaux57",
 *              "content": "Velit et vitae sint similique aut quia placeat. Blanditiis ut soluta quis magni animi. Nisi unde laboriosam vel quis non quo beatae.\nSunt iure est minima et totam sint eum. Pariatur quod officia sint voluptas non. Dolores laudantium temporibus velit dolorem sit. Aut omnis repellat at velit.",
 *              "date": "30/11/2016"
 *          }
 *  }
 *
 * @apiError (Erreur : 404) PhotoNotFound Photo inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error" : "invalid photo id : 1234"
 *     }
 */


