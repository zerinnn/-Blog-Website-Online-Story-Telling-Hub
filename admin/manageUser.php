<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'partials/header.php';

$currentAdminId = $_SESSION['userId'];
$query = "SELECT * FROM account WHERE NOT id='$currentAdminId'";
$users = mysqli_query($dbConnection, $query);

if (!$users) {
    echo "Error executing query: " . mysqli_error($dbConnection);
    exit();
}

if (isset($_SESSION['editUserSuccess'])) {
    $message = $_SESSION['editUserSuccess'];
    $messageClass = "success";
    unset($_SESSION['editUserSuccess']);
}
if (isset($_SESSION['editUser'])) {
    $message = $_SESSION['editUser'];
    $messageClass = "error";
    unset($_SESSION['editUser']);
}

if (isset($_SESSION['deleteUserSuccess'])) {
    $message = $_SESSION['deleteUserSuccess'];
    $messageClass = "success";
    unset($_SESSION['deleteUserSuccess']);
}
if (isset($_SESSION['deleteUser'])) {
    $message = $_SESSION['deleteUser'];
    $messageClass = "error";
    unset($_SESSION['deleteUser']);
}
?>

<section class="section dashboard">


    <?php if (isset($message)) : ?>
        <div class="alert-message <?= $messageClass ?> container"><?= $message ?></div>
    <?php endif; ?>
    <div class="container dashboardContainer">

        <button id="show_sidebar_btn" class="slidebar_toggle">
            <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
        </button>
        <button id="hide_sidebar_btn" class="slidebar_toggle">
            <ion-icon name="arrow-back" aria-hidden="true"></ion-icon>
        </button>

        <aside data-aside>
            <ul>
                <li>
                    <a href="addPost.php">
                        <ion-icon name="create-outline" aria-hidden="true"></ion-icon>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <ion-icon name="newspaper-outline" aria-hidden="true"></ion-icon>
                        <h5>Manage Post</h5>
                    </a>
                </li>
                <li>
                    <a href="addCategory.php">
                        <ion-icon name="pencil-outline" aria-hidden="true"></ion-icon>
                        <h5>Add Category</h5>
                    </a>
                </li>
                <li>
                    <a href="manageCategory.php" class="active">
                        <ion-icon name="list-sharp" aria-hidden="true"></ion-icon>
                        <h5>Manage Categories</h5>
                    </a>
                </li>
                <li>
                    <a href="">
                        <ion-icon name="people-outline" aria-hidden="true"></ion-icon>
                        <h5>Manage User</h5>
                    </a>
                </li>
            </ul>
        </aside>
        <main>
            <h2>Manage Users</h2>

            <?php if(mysqli_num_rows($users) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($users)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($user['firstName'] . " " . htmlspecialchars($user['lastName'])) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/editUser.php?id=<?= $user['id'] ?>" class="btn btn-primary">Edit</a></td>
                            <td><a href="<?= ROOT_URL ?>admin/deleteUser.php?id=<?= $user['id'] ?>" class="btn btn-primary danger">Delete</a></td>
                            <td><?= $user['isAdmin'] == 1 ? "YES" : "NO"; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="alert-message error"><?= "No users found" ?></div>
            <?php endif; ?>
        </main>
    </div>
</section>

<?php
include 'partials/footer.php';
?>