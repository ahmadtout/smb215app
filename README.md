# smb215app
Projet pour <b>isae cnam Smb215</b><br>
<br>
<br>
<b> Description générale:</b><br>
Cette application est désignée pour un usage scolaire <br>
Le but est de fournir les livres scolaires sous forme d'application mobile interactive, compatible avec les systèmes Android et IOS, disponible hors connection <br>
<br>
Le travail est donc divisé en deux parties : l'interface d'administration (SERVER SIDE), et l'interface utilisateur.<br>
<br>
<b>1- Interface d'administration - SERVER SIDE </b><br>
Cette interface, hebergée sur un serveur en ligne, doit permettre à l'administrateur, d'une manière simple, d'insérer ou de modifier le contenu du livre.<br>
Cette interface est principalement basée sur les langages HTML, PHP et MySQL.<br>
L'accès est protégé par un système d'authentification (login). <br>
<b>   - Mode d'emploi </b> <br>
L'éditeur doit tout d'abord reconstituer l'index du livre, en insérant les noms de tous les chapitres et les sous-parties, dans le volet consacré à cet emploi.<br>
Ensuite, depuis le volet d'édition, l'éditeur choisit le chapitre et la sous-partie où il va commencer à insérer le contenu dans un paragraphe. <br>
Il aura le choix, s'il le souhaite, d'insérer une image juste avant le paragraphe, et une autre juste après. Il pourra également ajouter une description pour chaque image.<br>
Par la suite, l'éditeur insère le texte désiré, tout en ayant une large palette d'outils de formatage de texte (police, taille, couleur, etc), en lui choisissant un titre convenable.<br>
Il peut également choisir la couleur de l'arrière-plan qui sera visible du côté de l'utilisateur.<br>
L'éditeur peut définir pour chaque page, un ou plusieurs <i>tags</i>, qui serviront à recenser les pages portant le même tag afin de faciliter la recherche des pages selon leur contenu (en vue d'une modification ultérieure par exemple).<br>
Le bouton "Save" servira à envoyer les données insérées vers la base de données MySQL.


Pour faire cela marchee offline <br>
on doit fair generes ces page sous la forme des pages HTML qui doit etres mis dans les files de l'application avant quelle est cree pour ce loder du locale.


