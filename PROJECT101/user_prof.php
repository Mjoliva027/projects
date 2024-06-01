<?php
session_start();
include("connection.php");
include("function.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$_SESSION;

if (isset($_POST['upload'])) {
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profileImage']['tmp_name'];
        $fileName = $_FILES['profileImage']['name'];
        $fileSize = $_FILES['profileImage']['size'];
        $fileType = $_FILES['profileImage']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Directory where uploaded files will be stored
        $uploadFileDir = 'uploads/profile_pictures/';
        
        // Check if the directory exists, if not, create it
        if (!file_exists($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        $dest_path = $uploadFileDir . $newFileName;

        // Allowed file types
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Update database with new profile image path
                $query = "UPDATE users SET profile_image='$dest_path' WHERE user_id='$user_id'";
                $result = mysqli_query($con, $query);

                if ($result) {
                    $success = "Profile picture updated successfully.";
                } else {
                    $error = "Error updating profile picture in database.";
                }
            } else {
                $error = "There was an error moving the uploaded file.";
            }
        } else {
            $error = "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
        }
    } else {
        $error = "No file uploaded or there was an upload error.";
    }
}

// Retrieve user information
$select_user = mysqli_query($con, "SELECT * FROM `users` WHERE user_id = '" . $_SESSION['user_id'] . "'");
if ($select_user && mysqli_num_rows($select_user) > 0) {
    $row = mysqli_fetch_assoc($select_user);
    $fullname = $row['fullname'];
    $profileImage = $row['profile_image'];
} else {
    $fullname = "Unknown User";
    $profileImage = "placeholder.jpg";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <style>

        /* Custom CSS styles */
        body {
            background-color: #f8f9fa;
        }

        .navbar-brand img {
            margin-right: 20px;
        }

        .custom-file-input {
            display: none;
        }

        .custom-file-label {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px; /* Adjust font size */
        }

        .custom-file-label:hover {
            background-color: #0056b3;
        }

        /* Make profile picture circular */
        #profileImage {
            border-radius: 50%; /* Make it a circle */
            overflow: hidden; /* Hide overflow for perfect circle */
            width: 150px; /* Adjust size */
            height: 150px; /* Adjust size */
            object-fit: cover; /* Ensure image covers the circle */
        }

        /* Reduce button sizes */
        .btn {
            padding: 5px 10px; /* Adjust padding */
            font-size: 12px; /* Adjust font size */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand" href="product.php">
                <img src="images/shoe-haven-high-resolution-logo-transparent.png" width="50" height="50" alt="Shoe Haven Logo">
                Shoe Haven
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="user_prof.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inbox.php">Inbox</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row">
            <div class="col-md-3 d-flex justify-content-center align-items-center">
                <section class="card">
                    <div class="profile-picture mt-3 text-center">
                        <img id="profileImage" src="<?php echo htmlspecialchars($profileImage); ?>" alt="Profile picture" class="card-img-top w-80">
                    </div>
                    <form method="POST" enctype="multipart/form-data" class="mt-3">
                        <div class="input-group">
                            <input type="file" id="fileInput" name="profileImage" accept="image/*" class="custom-file-input">
                            <label for="fileInput" class="custom-file-label">Choose File</label>
                        </div>
                        <button type="submit" name="upload" class="btn btn-primary btn-sm mt-2">Upload</button>
                    </form>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($fullname); ?></h5>
                    </div>
                </section>
            </div>
            <div class="col-md-9">
                <section class="card">
                    <div class="card-header">
                        <h3>Interests</h3>
                        <a href="#" class="btn btn-primary btn-sm float-end">Edit</a>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">All Sports</li>
                            <li class="list-group-item">Products</li>
                            <li class="list-group-item">Teams</li>
                            <li class="list-group-item">Athletes</li>
                            <li class="list-group-item">Cities</li>
                        </ul>
                        <p>Add your interests to shop a collection of products that are based on what you're into.</p>
                    </div>
                </section>
            </div>
        </div>
        
    </main>
    <div> <?php require_once('include/footer.php'); ?></div>
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fAIlT894z9Opbl3NsR5U2vt8LP6SX9mzxNfuqsGOaptbwHjbWEjHWCH+wxNsoCSt" crossorigin="anonymous"></script>

    <script>
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>



