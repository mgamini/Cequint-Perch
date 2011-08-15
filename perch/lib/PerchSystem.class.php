<?php

class PerchSystem
{
    static function set_page($page)
    {
        $Perch = Perch::fetch();
        $Perch->set_page($page);
    }
}


?>