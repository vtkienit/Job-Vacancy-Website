<?php

session_start();

require 'settings.php';

if(!isset($_SESSION['username']) || !isset($_SESSION['full_name'])){
    header("Location: login.php");
    exit();
}

// Khởi tạo biến
$error = '';
$message = '';
$showTable = false;
$result = null;
$type_query = 0;
$firstName = null;
$lastName = null;
$eoiNumber = null;
$sortField = '';
$query_display = '1';

// Xử lý Query Menu
if(!empty($_GET['query_display'])){
    $query_display = isset($_GET['query_display']) ? $_GET['query_display'] : '1';
}

// Xử lý sort theo Field
if(!empty($_GET['option_sort'])){
    $sortField = isset($_GET['option_sort']) ? $_GET['option_sort'] : '';
}

// Xử lý tìm kiếm theo họ và tên (Prepared Statement)
if (!empty($_GET['search_first_name']) || !empty($_GET['search_last_name'])) {
    $firstName = isset($_GET['search_first_name']) ? $_GET['search_first_name'] : '';
    $lastName = isset($_GET['search_last_name']) ? $_GET['search_last_name'] : '';

    if (empty($firstName) && empty($lastName)) {
        $error = "Invalid Search: Please enter at least one search field.";
    } else {
        $type_query = 1;
        $sql = "SELECT * FROM EOI WHERE firstName LIKE ? AND lastName LIKE ?";

        if ($sortField !== '') {
            $sql .= " ORDER BY $sortField";
        }

        $stmt = $conn->prepare($sql);
        $firstName = "%$firstName%";
        $lastName = "%$lastName%";
        $stmt->bind_param("ss", $firstName, $lastName);
        $stmt->execute();
        $result = $stmt->get_result();
        $showTable = $result->num_rows > 0;
        if (!$showTable) $error = "No matching applicants found.";
        $stmt->close();
    }
}

// Xử lý tìm kiếm theo EOI Number (Prepared Statement)
if (!empty($_GET['eoi_number'])) {
    $eoiNumber = $_GET['eoi_number'];
    $type_query = 2;
    $sql = "SELECT * FROM EOI WHERE EOInumber = ?";

    if ($sortField !== '') {
        $sql .= " ORDER BY $sortField";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $eoiNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $showTable = $result->num_rows > 0;
    if (!$showTable) $error = "No application found with EOI Number: $eoiNumber";
    $stmt->close();
}

// Xử lý xóa EOI theo Job Reference (Prepared Statement)
if (!empty($_GET['delete_job_ref'])) {
    $jobRef = $_GET['delete_job_ref'];
    $sql = "DELETE FROM EOI WHERE jobRef = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $jobRef);
    if ($stmt->execute()) {
        $message = "Applications with Job Reference $jobRef deleted successfully.";
    } else {
        $error = "Error deleting applications: " . $stmt->error;
    }
    $stmt->close();
}

// Xử lý cập nhật trạng thái EOI (Prepared Statement)
if (!empty($_GET['eoi_id']) && !empty($_GET['option'])) {
    $eoiId = $_GET['eoi_id'];
    $newStatus = $_GET['option'];

    $sql = "UPDATE EOI SET status = ? WHERE EOInumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $newStatus, $eoiId);
    if ($stmt->execute()) {
        $message = "Status updated successfully.";
    } else {
        $error = "Error updating status: " . $stmt->error;
    }
    $stmt->close();
}

// Xử lý hiển thị danh sách tất cả EOI
if (isset($_GET['list_all'])) {
    $type_query = 3;
    $sql = "SELECT * FROM EOI";

    if ($sortField !== '') {
        $sql .= " ORDER BY $sortField";
    }

    $result = $conn->query($sql);
    $showTable = $result->num_rows > 0;
    if (!$showTable) {
        $error = "No applications found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="images/logo.png">
    <meta name="description" content="Creating Web Application">
    <meta name="keywords" content="HTML, CSS">
    <meta name="author" content="Do Tien Loc">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header class="task-menu">
        <img src="images/user.png" width="110" height="110" alt="user">
        <h1> <?php echo $_SESSION['full_name']; ?> </h1>
        <strong><a href="index.php">Home</a></strong> |
        <strong><a href="manage.php">Manage EOIs</a></strong> |
        <strong><a href="logout.php">Log Out</a></strong>
    </header>

    <div class="manage-page">
        <div id="manageUser" class="content">
            <h2 class="section-title">Manage User</h2>
            <p class="section-description">Here you can manage user applications</p>

            <div class="menu-query">
                <ul>
                    <li>
                        <form class="class-menu-query" method="GET">
                            <input type="hidden" name="query_display" value="1">
                            <button <?php if ($query_display === '1') echo "style='color: #FF0000';"; ?>>List All</button>
                        </form>
                    </li>

                    <li>
                        <form class="class-menu-query" method="GET">
                            <input type="hidden" name="query_display" value="2">
                            <button <?php if ($query_display === '2') echo "style='color: #FF0000';"; ?>>List by EOI Number</button>
                        </form>
                    </li>

                    <li>
                        <form class="class-menu-query" method="GET">
                            <input type="hidden" name="query_display" value="3">
                            <button <?php if ($query_display === '3') echo "style='color: #FF0000';"; ?>>List by Name</button>
                        </form>
                    </li>

                    <li>
                        <form class="class-menu-query" method="GET">
                            <input type="hidden" name="query_display" value="4">
                            <button <?php if ($query_display === '4') echo "style='color: #FF0000';"; ?>>Delete by Job Reference</button>
                        </form>
                    </li>

                    <li>
                        <form class="class-menu-query" method="GET">
                            <input type="hidden" name="query_display" value="5">
                            <button <?php if ($query_display === '5') echo "style='color: #FF0000';"; ?>>Change Status</button>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="cards-container">
                <?php 
                    if ($query_display === '1'){
                        echo "<div class='card card-wide'>";
                        echo "<h3>List All EOIs</h3>";
                        echo "<form class='card-form' method='GET'>";
                        echo "<input type='hidden' name='query_display' value='1'>";
                        echo "<input type='hidden' name='list_all' value='1'>";
                        echo "<button class='card-button'>List All</button>";
                        echo "</form> </div>";
                    }elseif($query_display === '2'){
                        echo "<div class='card'>";
                        echo "<h3>List EOIs by EOI Number</h3>";
                        echo "<form class='card-form' method='GET'>";
                        echo "<input type='hidden' name='query_display' value='2'>";
                        echo "<input type='text' name='eoi_number' placeholder='EOI Number'>";
                        echo "<button class='card-button'>List EOIs</button>";
                        echo  "</form> </div>";
                        
                    }elseif($query_display === '3'){
                        echo "<div class='card'>";
                        echo "<h3>List EOIs by Applicant Name</h3>";
                        echo "<form class='card-form' method='GET'>";
                        echo "<input type='hidden' name='query_display' value='3'>";
                        echo "<input type='text' name='search_first_name' placeholder='First Name'>";
                        echo "<input type='text' name='search_last_name' placeholder='Last Name'>";
                        echo "<button class='card-button'>List EOIs</button>";
                        echo "</form> </div>";
                    }elseif($query_display === '4'){
                        echo "<div class='card'>";
                        echo "<h3>Delete EOIs by Job Reference</h3>";
                        echo "<form class='card-form' method='GET'>";
                        echo "<input type='hidden' name='query_display' value='4'>";
                        echo "<input type='text' name='delete_job_ref' placeholder='Job Reference'>";
                        echo "<button class='card-button'>Delete EOIs</button>";
                        echo "</form> </div>";
                    }elseif($query_display === '5'){
                        echo "<div class='card'>";
                        echo "<h3>Change EOI Status</h3>";
                        echo "<form class='card-form' method='GET'>";
                        echo "<input type='hidden' name='query_display' value='5'>";
                        echo "<input type='text' name='eoi_id' placeholder='EOI ID'>";
                        echo "<select name='option' class='status-select'>";
                        echo "<option value='New'>New</option>";
                        echo "<option value='Current'>Current</option>";
                        echo "<option value='Final'>Final</option>";
                        echo "</select>";
                        echo "<button class='card-button'>Update Status</button>";
                        echo "</form> </div>";
                    }
                ?>
            </div>
        </div>

        <?php if ($showTable && $result !== null): ?>
            <div class="sort-container">
                <form class="sort-form" method="GET">
                    <?php 
                        if($type_query==1){
                            echo "<input type='hidden' name='search_first_name' value=$firstName>";
                            echo "<input type='hidden' name='search_last_name' value=$lastName>";
                        }elseif($type_query==2){
                            echo "<input type='hidden' name='eoi_number' value=$eoiNumber>";
                        }elseif($type_query==3){
                            echo "<input type='hidden' name='list_all' value='1'>";
                        }
                    ?>
                    <label for="sort-field">Sort by:</label>
                    <select name="option_sort" id="sort-field">
                        <option value="" <?php if($sortField == '') echo "selected"; ?> >Default</option>

                        <option value="EOInumber ASC" <?php if($sortField =='EOInumber ASC') echo "selected"; ?> >Ascending EOI Number</option>
                        <option value="EOInumber DESC" <?php if($sortField =='EOInumber DESC') echo "selected"; ?> >Descending EOI Number</option>

                        <option value="jobRef ASC" <?php if($sortField =='jobRef ASC') echo "selected"; ?> >Ascending Job Reference</option>
                        <option value="jobRef DESC" <?php if($sortField =='jobRef DESC') echo "selected"; ?> >Descending Job Reference</option>

                        <option value="firstName ASC" <?php if($sortField =='firstName ASC') echo "selected"; ?> >Ascending First Name</option>
                        <option value="firstName DESC" <?php if($sortField =='firstName DESC') echo "selected"; ?> >Descending First Name</option>

                        <option value="lastName ASC" <?php if($sortField =='lastName ASC') echo "selected"; ?> >Ascending Last Name</option>
                        <option value="lastName DESC" <?php if($sortField =='lastName DESC') echo "selected"; ?> >Descending Last Name</option>

                        <option value="gender ASC" <?php if($sortField =='gender ASC') echo "selected"; ?> >Ascending Gender</option>
                        <option value="gender DESC" <?php if($sortField =='gender DESC') echo "selected"; ?> >Descending Gender</option>

                        <option value="status ASC" <?php if($sortField =='status ASC') echo "selected"; ?> >Ascending Status</option>
                        <option value="status DESC" <?php if($sortField =='status DESC') echo "selected"; ?> >Descending Status</option>
                    </select>

                    <button class="btn-img"></button>
                </form>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <p class="error-message"><?= $error ?></p>
        <?php endif; ?>

        <?php if ($message): ?>
            <p class="success-message"><?= $message ?></p>
        <?php endif; ?>

        <?php if ($showTable && $result !== null): ?>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>EOI Number</th>
                            <th>JobRef</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date of birth</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Suburb</th>
                            <th>State</th>
                            <th>Postcode</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['EOInumber']) ?></td>
                                <td><?= htmlspecialchars($row['jobRef']) ?></td>
                                <td><?= htmlspecialchars($row['firstName']) ?></td>
                                <td><?= htmlspecialchars($row['lastName']) ?></td>
                                <td><?= htmlspecialchars($row['dob']) ?></td>
                                <td><?= htmlspecialchars($row['gender']) ?></td>
                                <td><?= htmlspecialchars($row['address']) ?></td>
                                <td><?= htmlspecialchars($row['suburb']) ?></td>
                                <td><?= htmlspecialchars($row['state']) ?></td>
                                <td><?= htmlspecialchars($row['postcode']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.inc'; ?>
</body>
</html>
