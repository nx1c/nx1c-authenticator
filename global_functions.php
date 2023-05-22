<?php

/**
 * redirect to a specified url
 * @param string $url
 * @return never
 */
function redirect(string $url): never
{
    header("Location: $url");
    exit();
}

/**
 * get the users mac address
 * @return string
 */
function get_mac_address(): string
{
    ob_start();
    system('getmac');
    $Content = ob_get_contents();
    ob_clean();
    return substr($Content, strpos($Content,'\\')-20, 17);
}