<?php
include_once "db_connect.php";
$db = $GLOBALS['db'];
$menuItems = $db->getMenuItems();
?>

<?php foreach ($menuItems as $item) :

    if (isset($_SESSION['auth']) && $_SESSION['auth'] === true && $item['name'] !== "Sign In") { ?>
        <li class="tm-nav-item <?php echo str_contains($_SERVER['REQUEST_URI'], $item['url']) ? 'active' : null; ?>">
            <a href="<?php echo $item['url'] ?>" class="tm-nav-link">
                <i class="fa <?php echo $item['icon'] ?>"></i>
                <?php echo $item['name']; ?>
            </a>
        </li>
    <?php } else if (isset($_SESSION['auth']) && $_SESSION['auth'] === false && $item['name'] !== "Sign Out" && $item['name'] !== "My Profile") { ?>
        <li class="tm-nav-item <?php echo str_contains($_SERVER['REQUEST_URI'], $item['url']) ? 'active' : null; ?>">
            <a href="<?php echo $item['url'] ?>" class="tm-nav-link">
                <i class="fa <?php echo $item['icon'] ?>"></i>
                <?php echo $item['name']; ?>
            </a>
        </li>
    <?php } else if (!isset($_SESSION['auth']) && $item['name'] !== "Sign Out" && $item['name'] !== "My Profile") { ?>
        <li class="tm-nav-item <?php echo str_contains($_SERVER['REQUEST_URI'], $item['url']) ? 'active' : null; ?>">
            <a href="<?php echo $item['url'] ?>" class="tm-nav-link">
                <i class="fa <?php echo $item['icon'] ?>"></i>
                <?php echo $item['name']; ?>
            </a>
        </li>
<?php }
endforeach; ?>