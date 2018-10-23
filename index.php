<?php

if (is_404()) :
    (new Ayctor\Controllers\PageController)->notFound();
elseif (is_home()) :
    (new Ayctor\Controllers\PageController)->index();
else :
    (new Ayctor\Controllers\PageController)->index();
endif;
