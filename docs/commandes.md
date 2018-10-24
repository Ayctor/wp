# Commandes

Les commandes permettent d'éxecuter facilement des tâches côté serveur soit à la main dans le terminal soit depuis une tâche CRON.

Elles héritent de la classe `\WP_CLI_Command` qui est disponible en installant [WP CLI](https://wp-cli.org/fr/).

Il est fortement recommandé d'installer **WP CLI** afin de gérer plus facilement vos Wordpress, par exemple, pour télécharger les sources de Wordpress, il vous suffit de lancer la commande suivant dans le répertoire de votre projet : `wp download core`

Par défaut, le thème vient avec la commande **reset** qui contient la fonction **opcache** permettant simplement de réinitialiser Opcache.

Le nom de la classe que vous créez doit être le nom de votre commande, suivi du mot **Command**, le tout en [CamelCase](https://fr.wikipedia.org/wiki/Camel_case).

Exemple : **ResetCommand**
