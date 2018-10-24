# Routeur

Plutôt que de créer un fichier pour chaque templates de Wordpress, ce qui n'est pas très utile vu que dans le cas de ce thème, on ne met même pas de HTML dedans mais simplement un appel à la méthode d'un contrôleur correspondant au template, il est préférable et plus clair de n'utiliser que le fichier **index.php** comme un routeur.

Wordpress met à notre disposition toutes sortes de fonctions utilitaires telles que **is_404()**, c'est grâce à ces dernières qu'on peut créer notre routeur.

    <?php

    if (is_404()) :
        (new Ayctor\Controllers\PageController)->notFound();
    elseif (is_home()) :
        (new Ayctor\Controllers\PageController)->index();
    else :
        (new Ayctor\Controllers\PageController)->index();
    endif;

    ?>
