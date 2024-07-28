<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}
?>

<?php
if(!isset($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Store customer billing and shipping information in the session
    $_SESSION['customer']['cust_b_name'] = $_POST['billing_name'];
    $_SESSION['customer']['cust_b_cname'] = $_POST['billing_company'];
    $_SESSION['customer']['cust_b_phone'] = $_POST['billing_phone'];
    $_SESSION['customer']['cust_b_country'] = $_POST['billing_country'];
    $_SESSION['customer']['cust_b_address'] = $_POST['billing_address'];
    $_SESSION['customer']['cust_b_city'] = $_POST['billing_city'];
    $_SESSION['customer']['cust_b_state'] = $_POST['billing_state'];
    $_SESSION['customer']['cust_b_zip'] = $_POST['billing_zip'];

    $_SESSION['customer']['cust_s_name'] = $_POST['shipping_name'];
    $_SESSION['customer']['cust_s_cname'] = $_POST['shipping_company'];
    $_SESSION['customer']['cust_s_phone'] = $_POST['shipping_phone'];
    $_SESSION['customer']['cust_s_country'] = $_POST['shipping_country'];
    $_SESSION['customer']['cust_s_address'] = $_POST['shipping_address'];
    $_SESSION['customer']['cust_s_city'] = $_POST['shipping_city'];
    $_SESSION['customer']['cust_s_state'] = $_POST['shipping_state'];
    $_SESSION['customer']['cust_s_zip'] = $_POST['shipping_zip'];

    // Handle payment processing
    if (isset($_POST['payment_method'])) {
        // Store the selected payment method in the session
        $_SESSION['customer']['payment_method'] = $_POST['payment_method'];
        
        // For demonstration purposes, we assume payment is successful
        // In a real-world scenario, you would include payment processing logic here
        
        // Redirect to the payment success page
        header('Location: payment_success.php');
        exit;
    }
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_checkout; ?>)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1><?php echo LANG_VALUE_22; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <?php if(!isset($_SESSION['customer'])): ?>
                    <p>
                        <a href="login.php" class="btn btn-md btn-danger"><?php echo LANG_VALUE_160; ?></a>
                    </p>
                <?php else: ?>

                <h3 class="special"><?php echo LANG_VALUE_26; ?></h3>
                <div class="cart">
                    <table class="table table-responsive table-hover table-bordered">
                        <tr>
                            <th><?php echo '#' ?></th>
                            <th><?php echo LANG_VALUE_8; ?></th>
                            <th><?php echo LANG_VALUE_47; ?></th>
                            <th><?php echo LANG_VALUE_157; ?></th>
                            <th><?php echo LANG_VALUE_158; ?></th>
                            <th><?php echo LANG_VALUE_159; ?></th>
                            <th><?php echo LANG_VALUE_55; ?></th>
                            <th class="text-right"><?php echo LANG_VALUE_82; ?></th>
                        </tr>
                         <?php
                        $table_total_price = 0;

                        $i=0;
                        foreach($_SESSION['cart_p_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_qty'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_qty[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_current_price[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_featured_photo[$i] = $value;
                        }
                        ?>
                        <?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                            </td>
                            <td><?php echo $arr_cart_p_name[$i]; ?></td>
                            <td><?php echo $arr_cart_size_name[$i]; ?></td>
                            <td><?php echo $arr_cart_color_name[$i]; ?></td>
                            <td><?php echo 'RM'; ?><?php echo $arr_cart_p_current_price[$i]; ?></td>
                            <td><?php echo $arr_cart_p_qty[$i]; ?></td>
                            <td class="text-right">
                                <?php
                                $row_total_price = $arr_cart_p_current_price[$i] * $arr_cart_p_qty[$i];
                                $table_total_price += $row_total_price;
                                ?>
                                <?php echo 'RM'; ?><?php echo $row_total_price; ?>
                            </td>
                        </tr>
                        <?php endfor; ?>           
                        <tr>
                            <th colspan="7" class="total-text"><?php echo LANG_VALUE_81; ?></th>
                            <th class="total-amount"><?php echo 'RM'; ?><?php echo $table_total_price; ?></th>
                        </tr>
                        <?php
                        // Shipping cost calculation
                        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                        $statement->execute(array($_SESSION['customer']['cust_country']));
                        $total = $statement->rowCount();
                        if($total) {
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        } else {
                            $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        }                        
                        ?>
                        <tr>
                            <td colspan="7" class="total-text"><?php echo LANG_VALUE_84; ?></td>
                            <td class="total-amount"><?php echo 'RM'; ?><?php echo $shipping_cost; ?></td>
                        </tr>
                        <tr>
                            <th colspan="7" class="total-text"><?php echo LANG_VALUE_82; ?></th>
                            <th class="total-amount">
                                <?php
                                $final_total = $table_total_price + $shipping_cost;
                                ?>
                                <?php echo 'RM'; ?><?php echo $final_total; ?>
                            </th>
                        </tr>
                    </table> 
                </div>

                <form action="" method="post">
                    <div class="billing-address">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="special"><?php echo LANG_VALUE_161; ?></h3>
                                <table class="table table-responsive table-bordered table-hover table-striped bill-address">
                                    <tr>
                                        <td><?php echo LANG_VALUE_102; ?></td>
                                        <td><input type="text" name="billing_name" value="<?php echo $_SESSION['customer']['cust_b_name']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_103; ?></td>
                                        <td><input type="text" name="billing_company" value="<?php echo $_SESSION['customer']['cust_b_cname']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_104; ?></td>
                                        <td><input type="text" name="billing_phone" value="<?php echo $_SESSION['customer']['cust_b_phone']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_105; ?></td>
                                        <td>
                                            <select name="billing_country">
                                                <option value=""><?php echo LANG_VALUE_115; ?></option>
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_country");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                    $selected = '';
                                                    if($row['country_id'] == $_SESSION['customer']['cust_b_country']) {
                                                        $selected = 'selected';
                                                    }
                                                    echo '<option value="'.$row['country_id'].'" '.$selected.'>'.$row['country_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td><?php echo LANG_VALUE_107; ?></td>
                                        <td><input type="text" name="billing_city" value="<?php echo $_SESSION['customer']['cust_b_city']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_108; ?></td>
                                        <td><input type="text" name="billing_state" value="<?php echo $_SESSION['customer']['cust_b_state']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_109; ?></td>
                                        <td><input type="text" name="billing_zip" value="<?php echo $_SESSION['customer']['cust_b_zip']; ?>"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h3 class="special"><?php echo LANG_VALUE_162; ?></h3>
                                <table class="table table-responsive table-bordered table-hover table-striped ship-address">
                                    <tr>
                                        <td><?php echo LANG_VALUE_102; ?></td>
                                        <td><input type="text" name="shipping_name" value="<?php echo $_SESSION['customer']['cust_s_name']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_103; ?></td>
                                        <td><input type="text" name="shipping_company" value="<?php echo $_SESSION['customer']['cust_s_cname']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_104; ?></td>
                                        <td><input type="text" name="shipping_phone" value="<?php echo $_SESSION['customer']['cust_s_phone']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_105; ?></td>
                                        <td>
                                            <select name="shipping_country">
                                                <option value=""><?php echo LANG_VALUE_115; ?></option>
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_country");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                    $selected = '';
                                                    if($row['country_id'] == $_SESSION['customer']['cust_s_country']) {
                                                        $selected = 'selected';
                                                    }
                                                    echo '<option value="'.$row['country_id'].'" '.$selected.'>'.$row['country_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                   
                                        <td><?php echo LANG_VALUE_107; ?></td>
                                        <td><input type="text" name="shipping_city" value="<?php echo $_SESSION['customer']['cust_s_city']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_108; ?></td>
                                        <td><input type="text" name="shipping_state" value="<?php echo $_SESSION['customer']['cust_s_state']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo LANG_VALUE_109; ?></td>
                                        <td><input type="text" name="shipping_zip" value="<?php echo $_SESSION['customer']['cust_s_zip']; ?>"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="special"><?php echo "Choose Your Payment Details"; ?></h3>
                            <div class="payment-gateways">
                                <input type="radio" name="payment_method" value="PayPal"> PayPal<br>
                                <input type="radio" name="payment_method" value="Stripe"> Stripe<br>
                                <input type="radio" name="payment_method" value="Bank"> Bank Deposit<br>
                                <input type="radio" name="payment_method" value="CashOnDelivery"> Cash On Delivery<br>
                                <br>
                                <input type="submit" class="btn btn-primary" value="Place Order" name="form1">
                            </div>
                        </div>
                    </div>
                </form>
                
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
