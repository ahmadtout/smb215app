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
<br>
<b>1- Interface d'administration - <i>SERVER SIDE</i> </b><br>
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
Le bouton "Save" servira à envoyer les données insérées vers la base de données MySQL.<br>
<br>
Afin de rendre le livre disponible hors-conection, l'interface d'administration reconstitue les données entrées par l'éditeur sous forme de page HTML, qui sera copiée et integrée dans l'application mobile.<br>
<br>
<br>
<b>2- Interface utilisateur -<i> Application mobile</i></b><br>
C'est l'application téléchargeable sur les mobiles et les tablettes exploitant les systèmes Android ou IOS, qui contient le livre lisible par les utilisateurs.<br>
Cette application offre aux lecteurs de nombreuses options, dont :<br>
- Lecture classique <br>
- Navigation par chapitres (index)<br>
- Recherche d'un mot ou une phrase dans tout le livre.<br>
- Définition de marque-pages sur les parapgraphes désirées pour les retrouver plus facilement.<br>
- Mode de lecture nocturne <br>
- Commentaires personnels et commentaires d'utilisateurs (connection internet requise) <br>
- Choix de la taille de police.<br>
- Audiothèque <br>
- Reprise de la lecture au dernier paragraphe ouvert, après la fermeture de l'application. <br>
- Liens vers les autres livres du même éditeur.<br>
