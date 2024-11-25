<header>
    <a class="logo" href="../frontend/dashboard.php">ORMOC CAR DEALER</a>
    <a href="../frontend/cart.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="M240-80q-33 0-56.5-23.5T160-160v-480q0-33 23.5-56.5T240-720h80q0-66 47-113t113-47q66 0 113 47t47 113h80q33 0 56.5 23.5T800-640v480q0 33-23.5 56.5T720-80H240Zm0-80h480v-480h-80v80q0 17-11.5 28.5T600-520q-17 0-28.5-11.5T560-560v-80H400v80q0 17-11.5 28.5T360-520q-17 0-28.5-11.5T320-560v-80h-80v480Zm160-560h160q0-33-23.5-56.5T480-800q-33 0-56.5 23.5T400-720ZM240-160v-480 480Z"/></svg></a>
    <?php if(isset($_SESSION['username'])): ?>
        <div class="dropdown">
            <button class="dropbtn"><i class="fa-regular fa-user"></i> Hi, <?php echo htmlspecialchars($_SESSION['username']); ?> <i class="fa fa-caret-down"></i></button>
            <div class="dropdown-content">
                <a href="../frontend/order_history.php"><i class="fa-solid fa-paper-plane"></i><span>Order History</span></a>
                <!-- <a href="../frontend/order_status.php">Order Status</a> -->
                <a href="../logout.php" onclick="return confirm('Are you sure to logout?');" id="logout"><i class="fa-solid fa-power-off"></i>Sign Out</a>
            </div>
        </div>
    <?php endif; ?>
</header>

<link rel="stylesheet" href="../assets/css/includes-css/dropdown.css">