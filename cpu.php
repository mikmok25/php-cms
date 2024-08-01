<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pc Builder | CPU</title>
    <link rel="stylesheet" href="css/styles.css">
    
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
$brandFilter = isset($_GET['brand']) ? $_GET['brand'] : '';

// Check if a search term is set in the GET request
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Constructing the base SQL query
$sql = "SELECT * FROM cpu WHERE 1=1";
$countSql = "SELECT COUNT(*) FROM cpu WHERE 1=1";

// Append brand filter to the SQL queries if set
if (!empty($brandFilter)) {
    $sql .= " AND brand = '" . $brandFilter . "'";
    $countSql .= " AND brand = '" . $brandFilter . "'";
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



// Form for filters and search
echo "<form action='cpu.php' method='get'>
        Brand: <select name='brand'>
            <option value=''>All Brands</option>
            <option value='Intel'" . ($brandFilter == 'Intel' ? ' selected' : '') . ">Intel</option>
            <option value='AMD'" . ($brandFilter == 'AMD' ? ' selected' : '') . ">AMD</option>
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
                <th>Brand</th>
                <th>Speed</th>
                <th>Socket</th>
                <th>Cores</th>
                <th>Threads</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                  <td><img src='" . $row["image"] . "' alt='" . $row["name"] . "' width='50'></td>
                  <td><a href='". $row["url"] . "' target='_blank'>" . $row["name"] . " </a></td>
                  <td>" . $row["brand"] . "</td>
                  <td>" . $row["speed"] . " GHz</td>
                  <td>" . $row["socket"] . "</td>
                  <td>" . $row["coreCount"] . "</td>
                  <td>" . $row["threadCount"] . "</td>
              </tr>";
    }
    echo "</table>";

    // Pagination links
    echo "<div>";

    echo createPagination($totalPages, $page, ['brand' => $brandFilter, 'search' => $searchTerm]);
} else {
    echo "0 results";
}
$conn->close();

?>
</body>
</html>


