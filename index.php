<?php
ob_start();
?>

<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

require_once "db.php";

function checkPrivilege($uri = false) {
    $sql = '
        SELECT      regrex 
        FROM        `role_privilege` 
        INNER JOIN  privilege_detail 
        ON          role_privilege.id_privilege = privilege_detail.id_privilege 
        WHERE       id_role = '.$_SESSION['user'][0]['id_role'];

    $conn = open_database();
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $privilege_arr[] = $row;
    }

    if (!isset($_SESSION['user']['privileges'])) {
        foreach ($privilege_arr as $privilege) {
            $_SESSION['user']['privileges'][] = $privilege['regrex'];
        }
    }

    $uri = ($uri != false) ? $uri : $_SERVER['REQUEST_URI'];

    $privileges = implode("|", $_SESSION['user']['privileges']);
    preg_match('/index\.php$|index\.php\?type=account&action=add&id=\d+$|index\.php\?type=account&action=view$|index\.php\?type=dashboard$|index\.php\?type=reset_password$|index\.php\?type=logout$|' . $privileges . '/', $uri, $matches);
    return !empty($matches);
}

$privilegeResult = checkPrivilege();

if (!$privilegeResult) {
    header("Location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <title>TRANG NỘI BỘ CÔNG TY</title>
</head>

<body>
    <?php
    require_once "navbar.php";
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-3 p-0" id="sidebar_space">
                <?php require_once "sidebar.php" ?>
            </div>

            <div class="col-9" id="content_space">
                <?php
                if (isset($_GET['type']) && isset($_GET['action'])) {
                    $type = $_GET['type'];
                    switch ($_GET['action']) {
                        case "view":
                            $action = 'index';
                            break;
                        case "add":
                            $action = 'add';
                            break;
                        case "appoint":
                            $action = 'appoint';
                            break;
                        case "detail":
                            $action = 'detail';
                            break;
                    }
                    $url = $type . '/' . $action . '.php';
                    require_once($url);
                } else if (isset($_GET['type'])) {
                    require_once($_GET['type'] . '.php');
                } else {
                    require_once "dashboard.php";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="main.js"></script>

</body>

</html>