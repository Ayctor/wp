# Configurations

Le répertoires **config/** contient initialement trois fichiers :

- **blade.php** : fichier contenant la configuration de [Blade](https://laravel.com/docs/master/blade), le moteur de templating
- **mail.php** : fichier contenant la configuration des mails, vous n'avez rien a changé dans ce fichier car les valeurs sont récupérées depuis le fichier d'environnement.
- **plugins.php** : fichier contenant la liste des extensions requis par le thème.

Vous êtes bien entendu libre d'ajouter vos propres fichiers de configuration, ces derniers doivent contenir un tableau et vous pourrez ensuite y accéder via la fonction suivante **config()** comme suit : `config(regions-departments.regions)`.
