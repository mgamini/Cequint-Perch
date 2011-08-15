<?php

    $NavGroups = new PerchPages_NavGroups($API);

    $HTML = $API->get('HTML');

    $navgroups = $NavGroups->all();
    

?>