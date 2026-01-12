<?php
include '../db_connect.php';
session_start();

$id = $_SESSION['User_ID'];

if (!isset($_SESSION['User_Name'])) {
    header('Location: ./index.php');
    exit();
}

$username = $_SESSION['User_Name'];
$status = isset($_SESSION['status']) ? $_SESSION['status'] : '';
$alertType = isset($_SESSION['alert_type']) ? $_SESSION['alert_type'] : '';
unset($_SESSION['status']);
unset($_SESSION['alert_type']);

// Pagination variables
$results_per_page = 6; // Number of cards to display per page

// Calculate current page number
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Default to page 1 if not specified
$offset = ($page - 1) * $results_per_page;

// SQL query to retrieve sites with pagination
$sql = "SELECT Site_ID, Site_Name, Site_City, Site_State, Site_Description 
        FROM site 
        LIMIT $offset, $results_per_page";

$result = $conn->query($sql);
function getImagePath($site_name)
{
    $images = [
        'Lost World of Tambun' => '../img/lwot.jpg',
        'Petronas Twin Towers' => '../img/kl_1.jpg',
        'Armenian Street' => '../img/as.jpg',
        'Langkawi Sky Bridge' => '../img/lsb.jpg',
        'Tanjung Aru Beach' => '../img/tab.jpg',
        'Zoo Negara' => '../img/zn.jpg',
    ];
    return isset($images[$site_name]) ? $images[$site_name] : 'path_to_default_image.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/agent.min.css">
    <link rel="stylesheet" href="home_traveller.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="home_traveller.php">
                <img src="../img/logo1.png" alt="Logo" height="40">
            </a>

            <div class="navbar-collapse d-flex justify-content-between w-100">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                </ul>

                <a href="../login/logout.php" class="btn btn-outline-light me-3">Logout</a>
            </div>
        </div>
    </nav>


    <div class="container my-4">
        <h2 class="text-center">Explore</h2>
        <?php if ($status): ?>
            <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show mt-5" role="alert">
                <?php echo $status; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="d-flex justify-content-between mb-3">
            <form oninput="handleInput()">
                <div class="input-group mb-3">
                    <input type="text" name="search" value="<?php if (isset($_GET['search'])) {
                        echo $_GET['search'];
                    } ?>" class="form-control" placeholder="Search sites">
                    <button class="btn btn-outline-primary" type="submit" id="button-search">Search</button>
                </div>
            </form>

        </div>
        <?php
        if (isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . $msg . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>
    </div>

    <div class="row g-4">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $image_src = getImagePath($row['Site_Name']);
                ?>
                <div class="col-md-4">
                    <div class="card h-100" style="background-color: #D4F1F4;">
                        <a href="#?id=<?php echo $row['Site_ID']; ?>"
                            class="card-link text-decoration-none text-dark">
                            <img src="<?php echo $image_src ?>" class="card-img-top" alt="<?php echo $row['Site_City'] ?>">
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?php echo $row['Site_Name'] ?></h5>
                                <p class="card-text">
                                    <small class="text-muted"><?php echo $row['Site_State'] ?></small>
                                </p>
                                <p class="card-text"><?php echo $row['Site_Description'] ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No sites found</p>";
        }
        ?>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function logout() {
            sessionStorage.clear();
            window.location.href = "../index/index.php";
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
</body>

</html>
<?php
$conn->close();
?>