<?php
function getSlugFromUrl($url)
{
    $last_slash_pos = strrpos($url, "/");
    if ($last_slash_pos !== false) {
        return substr($url, $last_slash_pos + 1);
    } else {
        return ""; // Handle cases where there's no "/"
    }
}