# Utilitaires

Le dossier **app/Utils** correspondant au namespace **Ayctor\Utils** permet de stocker toutes les classes utilitaires du thème.

Il en existe déjà trois par défaut dont une nommée **Str** et servant à formater des chaînes de caractères.

Une autre nommée **Bugsnag** permet d'initialiser Bugsnag en recette et en production.

La dernière nommée **Helper** contient seulement une méthode servant à récupérer les fichiers compilés présent dans le dossier **buil/**. La méthode **mix** est à utiliser à chaque fois que vous avez besoin de récupérer un fichier se trouvant dans le répertoire **build/**.

Par exemple, pour avoir le fichier de sprite SVG on écrirai : `{{ \Ayctor\Utils\Helper::mix('/svg/sprite.svg') }}#menu`.
