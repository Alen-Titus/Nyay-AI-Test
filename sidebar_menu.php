<!-- sidebar navigation -->
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
php
<div class="navbar nav_title" style="border: 0;">
    <a href="home.php" class="site_title"><i class="fa fa-university"></i> <span>Library Pro </span></a>
</div>
<div class="clearfix"></div>

<!-- menu profile quick info -->
<?php
    include_once('include/dbcon.php'); // Use include_once to prevent re-declarations
    
    $user_query = mysqli_query($con, "SELECT * FROM admin WHERE admin_id='$id_session'") or die(mysqli_error($con));
    $row = mysqli_fetch_array($user_query);
    
    // Normalize the admin type to lowercase for robust checking
    $admin_type = strtolower($row['admin_type']); 
    
    // Use prepared statements with parameterized queries to prevent SQL injection
    $stmt = mysqli_prepare($con, "SELECT * FROM admin WHERE admin_id=?");
    mysqli_stmt_bind_param($stmt, 'i', $id_session);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_array($result)) {
        // Use prepared statements to prevent SQL injection
        $admin_image_query = mysqli_prepare($con, "SELECT admin_image FROM admin WHERE admin_id=?");
        mysqli_stmt_bind_param($admin_image_query, 'i', $id_session);
        mysqli_stmt_execute($admin_image_query);
        $admin_image_result = mysqli_stmt_get_result($admin_image_query);
        
        if ($admin_image_row = mysqli_fetch_array($admin_image_result)) {
            $admin_image = $admin_image_row['admin_image'];
            
            // Use prepared statements to prevent SQL injection
            $upload_query = mysqli_prepare($con, "SELECT upload_path FROM config WHERE id=?");
            mysqli_stmt_bind_param($upload_query, 'i', 1);
            mysqli_stmt_execute($upload_query);
            $upload_result = mysqli_stmt_get_result($upload_query);
            
            if ($config_row = mysqli_fetch_array($upload_result)) {
                $upload_path = $config_row['upload_path'];
                
                // Use prepared statements to prevent SQL injection
                $image_query = mysqli_prepare($con, "SELECT image FROM upload WHERE id=?");
                mysqli_stmt_bind_param($image_query, 'i', $admin_image);
                mysqli_stmt_execute($image_query);
                $image_result = mysqli_stmt_get_result($image_query);
                
                if ($image_row = mysqli_fetch_array($image_result)) {
                    $image_path = $upload_path . '/' . $image_row['image'];
                    
                    // Use prepared statements to prevent SQL injection
                    $img_src_query = mysqli_prepare($con, "SELECT img_src FROM upload WHERE id=?");
                    mysqli_stmt_bind_param($img_src_query, 'i', $admin_image);
                    mysqli_stmt_execute($img_src_query);
                    $img_src_result = mysqli_stmt_get_result($img_src_query);
                    
                    if ($img_src_row = mysqli_fetch_array($img_src_result)) {
                        $img_src = $img_src_row['img_src'];
                        
                        // Use prepared statements to prevent SQL injection
                        $alt_text_query = mysqli_prepare($con, "SELECT alt_text FROM upload WHERE id=?");
                        mysqli_stmt_bind_param($alt_text_query, 'i', $admin_image);
                        mysqli_stmt_execute($alt_text_query);
                        $alt_text_result = mysqli_stmt_get_result($alt_text_query);
                        
                        if ($alt_text_row = mysqli_fetch_array($alt_text_result)) {
                            $alt_text = $alt_text_row['alt_text'];
                            
                            // Use prepared statements to prevent SQL injection
                            $class_query = mysqli_prepare($con, "SELECT class FROM upload WHERE id=?");
                            mysqli_stmt_bind_param($class_query, 'i', $admin_image);
                            mysqli_stmt_execute($class_query);
                            $class_result = mysqli_stmt_get_result($class_query);
                            
                            if ($class_row = mysqli_fetch_array($class_result)) {
                                $class = $class_row['class'];
                                
                                // Use prepared statements to prevent SQL injection
                                $img_circle_query = mysqli_prepare($con, "SELECT img_circle FROM upload WHERE id=?");
                                mysqli_stmt_bind_param($img_circle_query, 'i', $admin_image);
                                mysqli_stmt_execute($img_circle_query);
                                $img_circle_result = mysqli_stmt_get_result($img_circle_query);
                                
                                if ($img_circle_row = mysqli_fetch_array($img_circle_result)) {
                                    $img_circle = $img_circle_row['img_circle'];
                                    
                                    // Use prepared statements to prevent SQL injection
                                    $profile_img_query = mysqli_prepare($con, "SELECT profile_img FROM upload WHERE id=?");
                                    mysqli_stmt_bind_param($profile_img_query, 'i', $admin_image);
                                    mysqli_stmt_execute($profile_img_query);
                                    $profile_img_result = mysqli_stmt_get_result($profile_img_query);
                                    
                                    if ($profile_img_row = mysqli_fetch_array($profile_img_result)) {
                                        $profile_img = $profile_img_row['profile_img'];
                                        
                                        // Use prepared statements to prevent SQL injection
                                        echo '<img src="' . $image_path . '" alt="' . $alt_text . '" class="' . $class . ' ' . $img_circle . ' ' . $profile_img . '" style="border-radius: 50%;">';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
                    <img src="images/user.png" alt="..." class="img-circle profile_img">
                <?php endif; ?>
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <!-- Using htmlspecialchars to prevent XSS attacks -->
                <h2><?php echo htmlspecialchars($row['firstname']); ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
                <!-- The inline style causing the large gap has been REMOVED -->
                <h3>File Information</h3>
                <div class="separator"></div>
                <ul class="nav side-menu">
                    <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="member.php"><i class="fa fa-users"></i> Members</a></li>
                    
                    <?php if($admin_type == 'admin') { ?>
                    <li><a href="admin.php"><i class="fa fa-user"></i> Admin / Librarian</a></li>
                    <?php } ?>
                    
                    <li><a href="book.php"><i class="fa fa-book"></i> Books</a></li>

                    <?php if($admin_type == 'librarian') { ?>
                    <li><a href="librarian.php"><i class="fa fa-user"></i> Librarian</a></li>
                    <?php } ?>

                    <?php if($admin_type == 'admin') { ?>
                    <li><a href="user_log_in.php"><i class="fa fa-history"></i> Members Record</a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="menu_section">
                <h3>Transaction Information</h3>
                <div class="separator"></div>
                <ul class="nav side-menu">
                    <li><a href="borrow.php"><i class="fa fa-edit"></i> Borrow / Return</a></li>
                    <li><a href="report.php"><i class="fa fa-file"></i> Reports</a></li>
                    <li><a href="individual_report.php"><i class="fa fa-file"></i> Individual Report</a></li>
                    <li><a href="borrowed_book.php"><i class="fa fa-book"></i> Borrowed books</a></li>
                    <li><a href="returned_book.php"><i class="fa fa-book"></i> Returned books</a></li>

                    <?php if($admin_type == 'admin') { ?>
                    <li><a href="settings.php"><i class="fa fa-cog"></i> Settings</a></li>
                    <?php } ?>

                    <li><a href="about_us.php"><i class="fa fa-info"></i> About Us</a></li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>
<!-- end of sidebar navigation -->