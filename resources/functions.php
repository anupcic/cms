<?php 

$upload_directory = "uploads";

// helper functions


function last_id(){
global $connection;
return mysqli_insert_id($connection);
}


function set_message($msg){
if(!empty($msg)) {
$_SESSION['message'] = $msg;
} else {
$msg = "";
    }
}


function display_message() {
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}


function redirect($location){
return header("Location: $location ");
}



// function redirect($location, $sec=0)
// {
//     if (!headers_sent())
//     {
//         header( "refresh: $sec;url=$location" ); 
//     }
//     elseif (headers_sent())
//     {
//         echo '<noscript>';
//         echo '<meta http-equiv="refresh" content="'.$sec.';url='.$location.'" />';
//         echo '</noscript>';
//     }
//     else
//     {
//         echo '<script type="text/javascript">';
//         echo 'window.location.href="'.$location.'";';
//         echo '</script>';
//     }
// }



function query($sql) {
global $connection;
return mysqli_query($connection, $sql);
}


function confirm($result){
global $connection;
if(!$result) {
die("QUERY FAILED " . mysqli_error($connection));
	}
}


function escape_string($string){
global $connection;
return mysqli_real_escape_string($connection, $string);
}



function fetch_array($result){
return mysqli_fetch_array($result);
}


/****************************FRONT END FUNCTIONS************************/


// get products 


function get_products() {
$query = query(" SELECT * FROM products");
confirm($query);
while($row = fetch_array($query)) {
$product_image = display_image($row['product_image']);
$product = <<<DELIMETER
<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"><img src="../resources/{$product_image}" alt=""></a>
        <div class="caption">
            <h4 class="pull-right">&#36;{$row['product_price']}</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
             <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
        </div>      
    </div>
</div>
DELIMETER;
echo $product;
		}
}


function get_categories(){
$query = query("SELECT * FROM categories");
confirm($query);
while($row = fetch_array($query)) {
$cat_image = display_image($row['cat_image']);
$categories_links = <<<DELIMETER
<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="category.php?id={$row['cat_id']}"><img src="../resources/{$cat_image}" alt=""></a>
        <div class="caption">
                 
        </div>  
    </div>
</div>
DELIMETER;
echo $categories_links;

     }
}

/////GET SELECTION OF THE IMJAGE CONTENT

function get_selection(){
$query = query("SELECT * FROM selectionimage");
confirm($query);
while($row = fetch_array($query)) {
$selectionimage_image = display_image($row['selectionimage_image']);
$selectionimage_links = <<<DELIMETER
<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="selection.php?id={$row['selectionimage_id']}"><img src="../resources/{$selectionimage_image}" alt=""></a>
        <div class="caption">

                 
        </div>  
    </div>
</div>
DELIMETER;
echo $selectionimage_links;

     }
}



///ANUP KUMAR



/////GET Final select image

function get_final_selection_product(){
    $query1=query("SELECT * FROM products WHERE fproduct_category_id = " . escape_string($_GET['id']) . " ");
    confirm($query1);
    while ($row1=fetch_array($query1)) {
        $query2=query("SELECT * FROM fproduct");
        confirm($query2);
        while ($row2=fetch_array($query2)) {
            if ($row1['product_title']==$row2['fproduct_title']) {
                $fproduct_image=display_image($row2['fproduct_image']);
                $selectionimage_links = <<<DELIMETER
                <div class="col-sm-4 col-lg-4 col-md-4">
                    <div class="thumbnail">
                        <a href="selection.php"><img src="../resources/{$selectionimage_image}" alt=""></a>
                        <div class="caption">
                        </div>
                    </div>
                </div>
DELIMETER;
                # code...
            }
            # code...
        }
        # code...
    }
}



///ANUP KUMAR



function get_products_in_cat_page() {
$query = query(" SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) . " ");
confirm($query);
while($row = fetch_array($query)) {
$product_image = display_image($row['product_image']);
$product = <<<DELIMETER
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" alt="">
                    <div class="caption">
                     <h3><a href="selection.php?id={$row['product_id']}">{$row['product_title']}</a>
                    </h3>                        
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

DELIMETER;

echo $product;


		}


}







function get_products_in_shop_page() {


$query = query(" SELECT * FROM products");
confirm($query);

while($row = fetch_array($query)) {

$product_image = display_image($row['product_image']);

$product = <<<DELIMETER


            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

DELIMETER;

echo $product;


        }


}




function login_user(){

if(isset($_POST['submit'])){

$username = escape_string($_POST['username']);
$password = escape_string($_POST['password']);
//echo("<script>console.log('PHP: ".$username."');</script>");
$query = query("SELECT * FROM Admins WHERE username = '{$username}' AND password = '{$password }' ");
confirm($query);
if(mysqli_num_rows($query) == 0) {
set_message("Your Password or Username are wrong");
redirect("login.php");
} else {

$_SESSION['username'] = $username;
redirect("admin");

         }

    }
}



function send_message() {
    if(isset($_POST['submit'])){ 
        $to          = "anupk1790@gmail.com";
        $from_name   =   $_POST['name'];
        $subject     =   $_POST['subject'];
        $email       =   $_POST['email'];
        $message     =   $_POST['message'];
        $headers = "From: {$from_name} {$email}";
        $result = mail($to, $subject, $message,$headers);
        if(!$result) {

            set_message("Sorry we could not send your message");
            redirect("contact.php");
        } else {

            set_message("Your Message has been sent");
            redirect("contact.php");
        }




    }




}



/****************************BACK END FUNCTIONS************************/

function display_orders(){
$query = query("SELECT * FROM orders");
confirm($query);
while($row = fetch_array($query)) {
$orders = <<<DELIMETER
<tr>
    <td>{$row['order_id']}</td>
    <td>{$row['order_amount']}</td>
    <td>{$row['order_transaction']}</td>
    <td>{$row['order_currency']}</td>
    <td>{$row['order_status']}</td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>
DELIMETER;
echo $orders;
    }
}




/************************ Admin Products Page ********************/

function display_image($picture) {
global $upload_directory;
return $upload_directory  . DS . $picture;
}





function get_products_in_admin(){
$query = query(" SELECT * FROM products");
confirm($query);
while($row = fetch_array($query)) {
$category = show_product_category_title($row['product_category_id']);
$product_image = display_image($row['product_image']);
$product = <<<DELIMETER
        <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}<br>
        <a href="index.php?edit_product&id={$row['product_id']}"><img width='100' src="../../resources/{$product_image}" alt=""></a>
            </td>
            <td>{$category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
             <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
DELIMETER;
echo $product;
        }
}


function show_product_category_title($product_category_id){
$category_query = query("SELECT * FROM categories WHERE cat_id = '{$product_category_id}' ");
confirm($category_query);
while($category_row = fetch_array($category_query)) {
return $category_row['cat_title'];
}
}






/***************************Add Products in admin********************/


function add_product() {
if(isset($_POST['publish'])) {
$product_title          = escape_string($_POST['product_title']);
$product_category_id    = escape_string($_POST['product_category_id']);
$product_price          = escape_string($_POST['product_price']);
$product_description    = escape_string($_POST['product_description']);
//$short_desc             = escape_string($_POST['short_desc']);
$product_quantity       = escape_string($_POST['product_quantity']);
$product_image          = $_FILES['file']['name'];
$image_temp_location    = $_FILES['file']['tmp_name']);
//move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $product_image);
// if(move_uploaded_file($image_temp_location  , "../uploads/$product_image")){
//     echo "string";}
//     else{
//         echo "not upload";
//     }

$query = query("INSERT INTO products(product_title, product_category_id, product_price, product_description, product_quantity, product_image) VALUES('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_description}', '{$product_quantity}', '{$product_image}')");
$last_id = last_id();
confirm($query);
set_message("New Product with id {$last_id} was Added");
//redirect("index.php?products");
        }
}



function show_categories_add_product_page(){
$query = query("SELECT * FROM categories");
confirm($query);
while($row = fetch_array($query)) {
$categories_options = <<<DELIMETER
 <option value="{$row['cat_id']}">{$row['cat_title']}</option>
DELIMETER;
echo $categories_options;
     }
}



/***************************updating product code ***********************/

function update_product() {
if(isset($_POST['update'])) {
$product_title          = escape_string($_POST['product_title']);
$product_category_id    = escape_string($_POST['product_category_id']);
$product_price          = escape_string($_POST['product_price']);
$product_description    = escape_string($_POST['product_description']);
$product_quantity       = escape_string($_POST['product_quantity']);
$product_image          = escape_string($_FILES['file']['name']);
$image_temp_location    = escape_string($_FILES['file']['tmp_name']);
if(empty($product_image)) {
$get_pic = query("SELECT product_image FROM products WHERE product_id =" .escape_string($_GET['id']). " ");
confirm($get_pic);
while($pic = fetch_array($get_pic)) {
$product_image = $pic['product_image'];
    }
}



move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $product_image);
$query = "UPDATE products SET ";
$query .= "product_title            = '{$product_title}'        , ";
$query .= "product_category_id      = '{$product_category_id}'  , ";
$query .= "product_price            = '{$product_price}'        , ";
$query .= "product_description      = '{$product_description}'  , ";
$query .= "product_quantity         = '{$product_quantity}'     , ";
$query .= "product_image            = '{$product_image}'          ";
$query .= "WHERE product_id=" . escape_string($_GET['id']);



$send_update_query = query($query);
confirm($send_update_query);
set_message("Product has been updated");
redirect("index.php?products");
        }
}

/*************************Categories in admin ********************/


function show_categories_in_admin() {
$category_query = query("SELECT * FROM categories");
confirm($category_query);
while($row = fetch_array($category_query)) {
$cat_id = $row['cat_id'];
$cat_title = $row['cat_title'];
$cat_image = display_image($row['cat_image']);
$category = <<<DELIMETER

<tr>
    <td>{$cat_id}</td>
    <td>{$cat_title}<br>
    <a href="index.php?delete_category&id={$row['cat_id']}"><img width='100' src="../../resources/{$cat_image}" alt=""></a>
    </td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_category.php?id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>
DELIMETER;
echo $category;
    }
}

//////////////////////////////////ANUP THIS FUNCTION WILL RETURN THE TYPES OF CATEGORY WE WOULD HAVE
function add_category() {
if(isset($_POST['add_category'])) {
$cat_title              = escape_string($_POST['cat_title']);
$cat_image              = escape_string($_FILES['file']['name']);
$image_temp_location     = escape_string($_FILES['file']['tmp_name']);
move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $cat_image);

//if(empty($cat_title) || $cat_title == " ") {
//echo "<p class='bg-danger'>THIS CANNOT BE EMPTY</p>";
//} else {
$insert_cat = query("INSERT INTO categories(cat_title,cat_image) VALUES('{$cat_title}','{$cat_image}') ");
$last_id = last_id();
confirm($insert_cat);
set_message("Category Created");
    //}
redirect("index.php?categories");
    }
}




//////////////////////////////////ANUP THIS FUNCTION WILL RETURN THE TYPES OF CATEGORY WE WOULD HAVE

 /************************admin users***********************/
function display_users() {
$category_query = query("SELECT * FROM users");
confirm($category_query);
while($row = fetch_array($category_query)) {
$user_id = $row['user_id'];
$username = $row['username'];
$email = $row['email'];
$password = $row['password'];
$user = <<<DELIMETER

<tr>
    <td>{$user_id}</td>
    <td>{$username}</td>
     <td>{$email}</td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$row['user_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>
DELIMETER;
echo $user;
    }
}


function add_user() {
if(isset($_POST['add_user'])) {
$username   = escape_string($_POST['username']);
$email      = escape_string($_POST['email']);
$password   = escape_string($_POST['password']);
// $user_photo = escape_string($_FILES['file']['name']);
// $photo_temp = escape_string($_FILES['file']['tmp_name']);


// move_uploaded_file($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo);


$query = query("INSERT INTO users(username,email,password) VALUES('{$username}','{$email}','{$password}')");
confirm($query);
set_message("USER CREATED");
redirect("index.php?users");
}
}




function get_reports(){
$query = query(" SELECT * FROM reports");
confirm($query);
while($row = fetch_array($query)) {
$report = <<<DELIMETER
        <tr>
             <td>{$row['report_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_title']}
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
DELIMETER;
echo $report;
        }
}
















//////////////////////////////////////////FINAL PRODUCT TO CHOOSE FROM THE SET OF DATA 
/////////////////ANUP KUMAR///////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function get_final_products_in_admin(){
$query = query(" SELECT * FROM fproducts");
confirm($query);
while($row = fetch_array($query)) {
$category = show_fproduct_category_title($row['fproduct_category_id']);
$fproduct_image = display_image($row['fproduct_image']);
$product = <<<DELIMETER
        <tr>
            <td>{$row['fproduct_id']}</td>
            <td>{$row['fproduct_title']}<br>
        <a href="index.php?edit_fproduct&id={$row['fproduct_id']}"><img width='100' src="../../resources/{$fproduct_image}" alt=""></a>
            </td>
            <td>{$category}</td>
            <td>{$row['fproduct_price']}</td>
            <td>{$row['fproduct_quantity']}</td>
            
             <td><a class="btn btn-danger" href="../../resources/templates/back/delete_fproduct.php?id={$row['fproduct_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>

        </tr>
DELIMETER;
echo $product;
        }
}


function show_final_product_category_title($fproduct_category_id){
$category_query = query("SELECT * FROM categories WHERE cat_id = '{$fproduct_category_id}' ");
confirm($category_query);
while($category_row = fetch_array($category_query)) {
return $category_row['cat_title'];
}
}






/***************************Add Products in admin********************/


function add_final_product() {
if(isset($_POST['publish'])) {
$fproduct_title          = escape_string($_POST['fproduct_title']);
$fproduct_category_id    = escape_string($_POST['fproduct_category_id']);
$fproduct_price          = escape_string($_POST['fproduct_price']);
$product_description    = escape_string($_POST['fproduct_description']);
//$short_desc             = escape_string($_POST['short_desc']);
$fproduct_quantity       = escape_string($_POST['fproduct_quantity']);
$fproduct_image          = escape_string($_FILES['file']['name']);
$fimage_temp_location    = escape_string($_FILES['file']['tmp_name']);
move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $fproduct_image);
$query = query("INSERT INTO products(fproduct_title, fproduct_category_id, fproduct_price, fproduct_description, fproduct_quantity, fproduct_image) VALUES('{$fproduct_title}', '{$fproduct_category_id}', '{$fproduct_price}', '{$fproduct_description}', '{$fproduct_quantity}', '{$fproduct_image}')");
$last_id = last_id();
confirm($query);
set_message("New Product with id {$last_id} was Added");
redirect("index.php?products");
        }
}



function show_final_categories_add_product_page(){
$query = query("SELECT * FROM selectionimage");
confirm($query);
while($row = fetch_array($query)) {
$categories_options = <<<DELIMETER
 <option value="{$row['selectionimage_id']}">{$row['selectionimage_title']}</option>
DELIMETER;
echo $categories_options;
     }
}



/***************************updating product code ***********************/
/*
function final_update_product() {
if(isset($_POST['update'])) {
$fproduct_title          = escape_string($_POST['fproduct_title']);
$fproduct_category_id    = escape_string($_POST['fproduct_category_id']);
$fproduct_price          = escape_string($_POST['fproduct_price']);
$fproduct_description    = escape_string($_POST['fproduct_description']);
$fproduct_quantity       = escape_string($_POST['fproduct_quantity']);
$fproduct_image          = escape_string($_FILES['file']['name']);
$image_temp_location    = escape_string($_FILES['file']['tmp_name']);
if(empty($fproduct_image)) {
$get_pic = query("SELECT fproduct_image FROM fproducts WHERE fproduct_id =" .escape_string($_GET['id']). " ");
confirm($get_pic);
while($pic = fetch_array($get_pic)) {
$product_image = $pic['fproduct_image'];
    }
}



move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY . DS . $fproduct_image);
$query = "UPDATE products SET ";
$query .= "product_title            = '{$fproduct_title}'        , ";
$query .= "product_category_id      = '{$fproduct_category_id}'  , ";
$query .= "product_price            = '{$fproduct_price}'        , ";
$query .= "product_description      = '{$fproduct_description}'  , ";
$query .= "product_quantity         = '{$fproduct_quantity}'     , ";
$query .= "product_image            = '{$fproduct_image}'          ";
$query .= "WHERE product_id=" . escape_string($_GET['id']);



$send_update_query = query($query);
confirm($send_update_query);
set_message("Product has been updated");
redirect("index.php?products");
        }
}

/*************************Categories in admin ********************/


function show_final_categories_in_admin() {
$category_query = query("SELECT * FROM selectionimage");
confirm($category_query);
while($row = fetch_array($category_query)) {
$fcat_id = $row['selectionimage_id'];
$fcat_title = $row['selectionimage_title'];
$fcat_image = display_image($row['selectionimage_image']);
$category = <<<DELIMETER

<tr>
    <td>{$fcat_id}</td>
    <td>{$fcat_title}<br>
    <a href="index.php?delete_category&id={$row['selectionimage_id']}"><img width='100' src="../../resources/{$fcat_image}" alt=""></a>
    </td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_final_category.php?id={$row['selectionimage_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>
DELIMETER;
echo $category;
    }
}

//////////////////////////////////ANUP THIS FUNCTION WILL RETURN THE TYPES OF CATEGORY WE WOULD HAVE
function add_final_category() {
if(isset($_POST['add_selectionimage'])) {
$cat_title              = escape_string($_POST['selectionimage_title']);
$cat_image              = escape_string($_FILES['file']['name']);
$imag_temp_location     = escape_string($_FILES['file']['tmp_name']);
move_uploaded_file($imag_temp_location  , UPLOAD_DIRECTORY . DS . $cat_image);

//if(empty($cat_title) || $cat_title == " ") {
//echo "<p class='bg-danger'>THIS CANNOT BE EMPTY</p>";
//} else {
$insert_cat = query("INSERT INTO selectionimage(selectionimage_title,selectionimage_image) VALUES('{$cat_title}','{$cat_image}') ");
$last_id = last_id();
confirm($insert_cat);
set_message("Category Created");
    //}
redirect("index.php?categories");
    }
}















 ?>