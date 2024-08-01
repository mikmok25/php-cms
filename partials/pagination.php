<?php
function createPagination($totalPages, $currentPage, $urlParams) {
    $paginationHTML = "<div class='pagination'>";

    for ($i = 1; $i <= $totalPages; $i++) {
        // Build the URL query string for each page link
        $linkParams = http_build_query(array_merge($urlParams, ['page' => $i]));
        $paginationHTML .= "<a href='?" . $linkParams . "'";
        if ($i == $currentPage) {
            $paginationHTML .= " class='active'";
        }
        $paginationHTML .= ">" . $i . "</a> ";
    }

    $paginationHTML .= "</div>";
    return $paginationHTML;
}
?>
