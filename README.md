# MyWishList
Lien pour le site :
https://webetu.iutnc.univ-lorraine.fr/www/cerisara1u/MyWishList/www/index.php/accueil

Lien pour le dépôt :
https://github.com/cerisaratheo/MyWishList


Participant :

1 . Afficher une liste de souhaits - Jérôme

	Etat : La liste est affichée en détaille à partir d’un token. L'état de la réservation n’est pas affiché, la date d’échéance n’est pas prise en compte.


2 . Afficher un item d'une liste - Jérôme

	Etat : L’affichage d'un item présente toutes ses informations détaillées. L’image de l’item et l’etat de réservation ne sont pas affichés.
	
	
3 . Réserver un item - Théo (y accéder par le lien de partage)

	Etat : Le bouton existe (ainsi que les méthodes) mais la réservation ne fonctionne plus (après l’ajout sur webetu) → le lien est mauvais, il faut donc le changer pour pouvoir accéder à la fonctionnalité
	
	Une fois que vous vous trouvez sur le lien affichant l’item et le bouton de réservation (un lien de ce type : webetu.iutnc.univ-lorraine.fr/www/cerisara1u/MyWishList/www/index.php/participation/nosecure1/23 ), il suffit de rajouter “/reservation” à la fin de l’url et nous accédons à la partie de réservation.


4 . Ajouter un message avec sa réservation - Théo

	Etat : Comme la réservation d’item, l’ajout d’un message lors de la réservation ne fonctionne plus → demande un changement du lien


5 . Ajouter un message sur une liste


Créateur :

6 . Créer une liste - Jérôme

	Etat : L’utilisateur doit obligatoirement être authentifié pour créer une liste. Un formulaire permet de saisir les informations générales de la liste mais les balises HTML sont interdites. Lors de sa création un token est créé pour accéder à cette liste en modification.
	

7 . Modifier les informations générales d'une listes - Vincent

	Etat : Entierement fait.
	
	
8 . Ajouter des item - Jonah

	Etat : Entierement fait.
	
	
9 . Modifier un item - Jayson

	Etat : La modification de l’item est possible après la réservation de cet item
	

13 . Supprimer une image d’un item

14 . Partage une liste - Jayson

	Etat : Etat : Entierement fait.



Extensions :

17 . Créer un compte - Jérôme

	Etat : Entierement fait. Tout utilisateur non inscrit peut créer un compte à l'aide d'un formulaire et choisit alors un login et un mot de passe.
	
	
18 . S'authentifier - Jérôme

	Etat : Entierement fait. Un utilisateur inscrit peut s'authentifier, une variable de session permet de maintenir l'état authentifié.
	

28 . Joindre des listes à son compte - Jérôme

	Etat : Quand un utilisateur authentifié crée une nouvelle liste, elle est automatiquement jointe à son compte.


Fonctionnalités non réalisées : 

10 . Supprimer un item

11 . Rajouter une image à un item

12 . Modifier une image d’un item

15 . Consulter les réservation d’une liste avant échéance

16 . Consulter les réservations et messages d’une de ses listes après échéance

19 . Modifier son compte

20 . Rendre une liste publique

21 . Afficher les listes de souhaits publiques

23 . Participer à une cagnotte

24 . Uploader une image

25 . Créer un compte participant

26 . Afficher la liste des créateurs

27 . Supprimer son compte





Installation sur une machine quelconque :

 - Il faut avoir un serveur web (type apache) et MySql sur sa machine pour que tout fonctionne correctement.

 - Executer le script base_mywishlist pour avoir une base de donnée utilisable.

 - Executer la commande "composer install" dans le dossier src.
