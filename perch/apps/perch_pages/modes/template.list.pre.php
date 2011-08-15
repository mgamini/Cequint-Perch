<?php

    $Templates = new PerchPages_Templates($API);

    $HTML = $API->get('HTML');

    $Templates->find_and_add_new_templates();


    $templates = $Templates->all();
    

?>