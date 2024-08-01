<?php
function createFilterForm($action, $brandFilter, $searchTerm) {
    $formHTML = "<form action='$action' method='get'>
                    Brand: <select name='brand'>
                        <option value=''>All Brands</option>
                        <option value='Intel'" . ($brandFilter == 'Intel' ? ' selected' : '') . ">Intel</option>
                        <option value='AMD'" . ($brandFilter == 'AMD' ? ' selected' : '') . ">AMD</option>
                    </select>
                    Search: <input type='text' name='search' value='" . $searchTerm . "'>
                    <input type='submit' value='Filter/Search'>
                 </form>";
    return $formHTML;
}

function processFilterSearch() {
    $brandFilter = isset($_GET['brand']) ? $_GET['brand'] : '';
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
    return [$brandFilter, $searchTerm];
}
?>
