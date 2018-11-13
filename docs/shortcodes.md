# Shortcodes

Les shortcodes sont une fonctionnalités très utiles de Wordpress et de base vraiment simple à mettre en place mais avec ce thème, il ne vous suffit que de créer un fichier dans le namespace **\Ayctor\Shortcodes**, par exemple : **Example.php**.

Vous pouvez également utiliser la commande blueprint : `wp blueprint shortcode Example`.

Vous n'avez plus qu'à renseigner le **nom** et le **template** de votre shortcode.

    <?php

    namespace Ayctor\Shortcodes;

    use WpCore\Shortcodes\Shortcode;

    /**
     * Class Example to set Example shortcode
     */
    class Example extends Shortcode
    {
        /**
         * Name of the shortcode to use in wp admin
         *
         * @var string
         */
        protected $name = 'example';

        /**
         * Defaults values for arguments
         *
         * @var array
         */
        protected $defaults = [];

        /**
         * Blade template of the shortcode
         *
         * @var string
         */
        protected $template = 'shortcodes.example';
    }
    
    ?>

Vous pouvez aussi définir des paramètres à passer à votre shortcodes.

Ensuite, il ne reste qu'à écrire le HTML de votre shortcode en créant un fichier dans le répertoire **resources/views/shortcodes/** portant le nom que vous avez défini dans la propriété **template** de votre classe.
