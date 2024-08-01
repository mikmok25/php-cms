<?php 

function formatStorage($sizeInGB) {
    if ($sizeInGB >= 1000) {
        return $sizeInGB / 1000 . 'TB';  // Converts GB to TB for sizes 1000GB and above
    }
    return $sizeInGB . ' GB';
}