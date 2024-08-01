<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC PART | RAM</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
<?php
include 'db.php';
include 'partials/pagination.php';

// Pagination and filtering setup
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$itemsPerPage = 20;
$offset = ($page - 1) * $itemsPerPage;

// Check if a brand filter is set in the GET request
$typeFilter = isset($_GET['type']) ? $_GET['type'] : '';

// Check if a search term is set in the GET request
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Constructing the base SQL query
$sql = "SELECT * FROM memory WHERE 1=1";
$countSql = "SELECT COUNT(*) FROM memory WHERE 1=1";

// Append brand filter to the SQL queries if set
if (!empty($typeFilter)) {
    $sql .= " AND `type` = '" . $typeFilter . "'";
    $countSql .= " AND `type` = '" . $typeFilter . "'";
}

// Append search term to the SQL queries if set
if (!empty($searchTerm)) {
    $sql .= " AND name LIKE '%" . $searchTerm . "%'";
    $countSql .= " AND name LIKE '%" . $searchTerm . "%'";
}

// Append limit and offset for pagination
$sql .= " LIMIT $offset, $itemsPerPage";

// Execute the count query
$totalResult = $conn->query($countSql);
$totalRows = $totalResult->fetch_row()[0];
$totalPages = ceil($totalRows / $itemsPerPage);

// Execute the main query
$result = $conn->query($sql);

include 'partials/nav.php';

echo "<form action='ram.php' method='get'>
        Brand: <select name='type'>
            <option value=''>All Type</option>
            <option value='DDR3'" . ($typeFilter == 'DDR3' ? ' selected' : '') . ">DDR3</option>
            <option value='DDR4'" . ($typeFilter == 'DDR4' ? ' selected' : '') . ">DDR4</option>
            <option value='DDR5'" . ($typeFilter == 'DDR5' ? ' selected' : '') . ">DDR5</option>
        </select>
        Search: <input type='text' name='search' value='" . $searchTerm . "'>
        <input type='submit' value='Filter/Search'>
      </form>";

// Display results in a table
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Type</th>
                <th>Size</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                  <td><img src='" . ($row["image"] ? $row["image"] : "https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/256px-No_image_available.jpg") . "' alt='" . $row["name"] . "' width='50'></td>
                  <td>" . $row["name"] . "</td>
                  <td>" . $row["type"] . " GHz</td>
                  <td>" . $row["size"] . " GB</td>
              </tr>";
    }
    echo "</table>";

    // Pagination links
    echo "<div>";

    echo createPagination($totalPages, $page, ['type' => $typeFilter, 'search' => $searchTerm]);
} else {
    echo "0 results";
}
$conn->close();

?>
    
</body>
</html>


