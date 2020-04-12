<?php

// ********** MARKO MARKOVIC ************

/*

if($conn_amso) 
{
    echo "Konektovan na amso";
} 
else 
{
    echo "Greska prilikom konekcije";
}
*/

// ------------ helper funkcije -------------------

/* 
// poslednji id za mysql
function last_id()
{
    global $conn_amso;
    return mysqli_insert_id($conn_amso);
}
*/

// $uploads_directory = "uploads";

function set_message($msg)
{
    if(!empty($msg))
    {
        $_SESSION['message'] = $msg;
    }
    else 
    {
        $msg = "";
    }
}

function display_message()
{
    if(isset($_SESSION['message']))
    {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}


function redirect($location)
{
    header("Location: $location");
}

function query($sql)
{
    global $conn_amso;

    return pg_query($conn_amso, $sql);
}

function confirm($result)
{
    global $conn_amso;

    if(!$result)
    {
        die("Query failed".pg_error($conn_amso));
    }
}

function escape_string($string)
{
    global $conn_amso;

    return pg_escape_string($conn_amso, $string);
}

function fetch_array($result)
{
    return pg_fetch_array($result);
}


// ********************* FRON END FUNCTIONS *****************************

function get_products()
{
    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query))
    {
        $product_price = $row['product_price'];
        $product_price = number_format($product_price,2,",",".");

        $product = <<<DELIMETER

        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail" style="height:350px;">
                    <a href="item.php?id={$row['product_id']}" ><img src="..resources/{$row['product_image']}" alt="" style="height:150px;" ></a>
                <div class="caption">
                    <h4 class="pull-right">$product_price RSD</h4>
                    <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
                    <p>See more snippets like this online store </p>
                        <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}" style="position:absolute; bottom:30px;" >Add to cart</a>    
                </div>
            </div>
        </div>


DELIMETER;

        echo $product;
    }

}


function get_cetegories()
{
    $query = query("SELECT * FROM ecategories");
    confirm($query);

    while($row = fetch_array($query))
    {
        $category_links = <<<DELIMETER
        <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
DELIMETER;
        echo $category_links;
    }

}


function get_products_in_cat_page()
{
    $query = query("SELECT * FROM products WHERE product_ecategory_id = ".escape_string($_GET['id'])." ");
    confirm($query);

    while($row = fetch_array($query))
    {
        // echo $row['product_price'];
        $product = <<<DELIMETER

        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail" style="height:350px;">
                <img src="../resources/uploads/{$row['product_image']}" alt="" style="height:150px;" >
                <div class="caption">
                    <h3>{$row['product_title']}</h3>
                    <p>Neki tekst opid direkt ukucan</p>
                    <p style="position:absolute; bottom:30px;">
                        <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now</a> 
                        <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                    </p>
                </div>
            </div>
        </div>
DELIMETER;
    
        echo $product;
    }
}


function get_products_in_shop_page()
{
    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query))
    {
        // echo $row['product_price'];
        $product = <<<DELIMETER

        <div class="col-md-3 col-sm-6 hero-feature">
            <div class="thumbnail" style="height:350px;">
                <img src="../resources/uploads/{$row['product_image']}" alt="" style="height:150px;">
                <div class="caption">
                    <h3>{$row['product_title']}</h3>
                    <p>Neki tekst opid direkt ukucan</p>
                    <p style="position:absolute; bottom:30px;">
                        <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now</a> 
                        <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                    </p>
                </div>
            </div>
        </div>
DELIMETER;
    
        echo $product;
    }
}



function login_user()
{
    if(isset($_POST['submit']))
    {
        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);

        $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
        confirm($query);

        if(pg_num_rows($query) == 0)
        {
            set_message("Your password or username are wrong");
            redirect("login.php");
        }
        else 
        {
            $_SESSION['username'] = $username;
            // set_message("Welcome to Admin {$username}");
            redirect("admin");
        }

    }

}

// sundbox  // mare@business.example.com  sb-1eghz1430438@business.example.com  // mare1234   0_xMh0Ql

function send_message()
{
    if(isset($_POST['submit']))
    {
        $to        = "markovicm.1403@gmail.com";

        $from_name = $_POST['name'];
        $subject   = $_POST['subject'];
        $email     = $_POST['email'];
        $message   = $_POST['message'];

        $headers = "From: {$from_name} {$email}";

        $result = mail($to, $subject, $message, $headers);

        if(!$result)
        {
            set_message("Sorry, email could not be sent");
            redirect("contact.php");
        }
        else 
        {
            set_message("Your message has been sent");
            redirect("contact.php");
        }

    }
}





// ********************* BACK END FUNCTIONS *****************************

function display_orders()
{
    $query = query("SELECT * FROM orders");
    confirm($query);

    while($row = fetch_array($query))
    {
        $orders = <<<DELIMETER

        <tr>
            <td>{$row['order_id']}</td>
            <td>{$row['order_amount']}</td>
            <td>{$row['order_transaction']}</td>
            <td>{$row['order_currency']}</td>
            <td>{$row['order_status']}</td>
            <td>
                <a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </td>
        </tr>

DELIMETER;

        echo $orders;

    }

}

// prikaz slike 
function display_image($picture)
{
    global $uploads_directory;
    return $uploads_directory.DS.$picture;
    //return "uploads".DS.$picture;
}


function  get_products_in_admin()
{
    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query))
    {
        $category = show_product_category_title($row['product_ecategory_id']);

        // $product_image = display_image({$row['product_image']}); // slika koja je bez putanje, tj treba promeniti pri upisu putanju ako zelim ovako
        // image putanja ../../resources/uploads/{$row['product_image']} // izmeni pri uploadu ako zelis

        // echo $row['product_price'];
        $product = <<<DELIMETER

        <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}<br>
                <a href="index.php?edit_product&id={$row['product_id']}" ><img src="{$row['product_image']}" height="120" width="180" alt=""></a>
            </td>
            <td>{$category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td>
                <a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </td>
        </tr>

DELIMETER;
    
        echo $product;
    }
}



function show_product_category_title($product_category_id)
{
    $category_query = query("SELECT * FROM ecategories WHERE cat_id = '{$product_category_id}' ");
    confirm($category_query);

    while($category_row = fetch_array($category_query))
    {
        return $category_row['cat_title'];
    }

}


function add_product()
{
    if(isset($_POST['publish']))
    {
       
        $product_title       = escape_string($_POST['product_title']);
        $product_category_id = escape_string($_POST['product_ecategory_id']);
        $product_description = escape_string($_POST['product_description']);
        $product_price       = escape_string($_POST['product_price']);
        $short_desc          = escape_string($_POST['short_desc']);
        $product_quantity    = escape_string($_POST['product_quantity']);
    // slika za upload
        $product_image       = escape_string($_FILES['file']['name']);
        $image_temp_location = escape_string($_FILES['file']['tmp_name']);

        $img_root = '../../resources/uploads/';
        mkdir($img_root, 0777, true);
        $target_dir = $img_root . $product_image;
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir);

        // move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY .DS. $product_image);

        $query = query("INSERT INTO products (product_title, product_ecategory_id, product_description, product_price, short_desc, product_quantity, product_image)
                            VALUES('{$product_title}', '{$product_category_id}', '{$product_description}', '{$product_price}', '{$short_desc}', '{$product_quantity}', '{$target_dir}')");

        // RETURNING product_id"
        // $last_id_arr = fetch_array($query);
        // $last_id = $last_id_arr['product_id'];

        confirm($query);

        set_message("New product was added");
        redirect("index.php?products");

    }

}



function show_categories_add_product_page()
{
    $query = query("SELECT * FROM ecategories");
    confirm($query);

    while($row = fetch_array($query))
    {
        $categories_options = <<<DELIMETER

        <option value="{$row['cat_id']}">{$row['cat_title']}</option>

DELIMETER;
        echo $categories_options;
    }

}


function update_product()
{
    if(isset($_POST['update']))
    {
       
        $product_title        = escape_string($_POST['product_title']);
        $product_category_id  = escape_string($_POST['product_category_id']);
        $product_description  = escape_string($_POST['product_description']);
        $product_price        = escape_string($_POST['product_price']);
        $short_desc           = escape_string($_POST['short_desc']);
        $product_quantity     = escape_string($_POST['product_quantity']);
    // slika za upload
        $product_image        = escape_string($_FILES['file']['name']);
        $image_temp_location  = escape_string($_FILES['file']['tmp_name']);


        if(empty($product_image))
        {
            $get_pic = query("SELECT product_image FROM products WHERE product_id =".escape_string($_GET['id'])."");
            confirm($get_pic);

            while($pic = fetch_array($get_pic))
            {
                $product_image = $pic['product_image'];
            }

        } 


        $img_root = '../../resources/uploads/';
        mkdir($img_root, 0777, true);
        $product_image = $img_root . $product_image;
        move_uploaded_file($_FILES["file"]["tmp_name"], $product_image);

    //   move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY .DS. $product_image);

        $query = "UPDATE products SET ";
        $query .= "product_title        = '{$product_title}', ";
        $query .= "product_ecategory_id = '{$product_category_id}', ";
        $query .= "product_description  = '{$product_description}', ";
        $query .= "product_price        = '{$product_price}', ";
        $query .= "short_desc           = '{$short_desc}', ";
        $query .= "product_quantity     = '{$product_quantity}', ";
        $query .= "product_image        = '{$product_image}' ";
        $query .= "WHERE product_id     = ".escape_string($_GET['id'])." ";

        $send_update_query = query($query);
        confirm($send_update_query);

        set_message("New product has been added");
        redirect("index.php?products");

    }

}



function show_categories_in_admin()
{
    $query = query("SELECT * FROM ecategories");
    confirm($query);
    
    while($row = fetch_array($query))
    {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        $category = <<<DELIMETER

        <tr>
            <td>{$cat_id}</td>
            <td>{$cat_title}</td>
            <td>
                <a class="btn btn-danger" href="../../resources/templates/back/delete_category.php?id={$row['cat_id']}">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </td>
        </tr>

DELIMETER;

        echo $category;

    }
}



function add_category()
{
    if(isset($_POST['add_category']))
    {
        $cat_title = escape_string($_POST['cat_title']);

        if(empty($cat_title) || $cat_title == " ")
        {   
            echo "<p class='bg-danger'>This can not be empty</p>";
        }
        else 
        {
            $insert_category = query("INSERT INTO ecategories(cat_title)
                                VALUES('{$cat_title}')");
            confirm($insert_category);

            set_message("Categry created");
            // redirect("index.php?categories");
        }
    }
}



function display_users()
{
    $query = query("SELECT * FROM users");
    confirm($query);
    
    while($row = fetch_array($query))
    {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $email = $row['email'];
        $password = $row['password'];

        $user = <<<DELIMETER

        <tr>
            <td>{$user_id}</td>
            <td>{$username}</td>
            <td>{$email}</td>
            <td>
                <a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$row['user_id']}">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </td>
        </tr>

DELIMETER;

        echo $user;

    }
}



function add_user()
{
    if(isset($_POST['add_user']))
    {

        $username = escape_string($_POST['username']);
        $email = escape_string($_POST['email']);
        $password = escape_string($_POST['password']);

    //    $user_photo = escape_string($_FILE['file']['name']);
    //    $photo_temp = escape_string($_FILE['file']['tmp_name']);

/*
        $img_root = '../../resources/uploads/';
        mkdir($img_root, 0777, true);
        $product_image = $img_root . $product_image;
        move_uploaded_file($_FILES["file"]["tmp_name"], $product_image);
*/

    //    move_uploaded_file($photo_temp, UPLOAD_DIRECTORY .DS. $user_photo);

        $query = query("INSERT INTO users(username, email, password)
                            VALUES('{$username}', '{$email}', '{$password}')");
        confirm($query);

        set_message("USER CREATED");
        redirect("index.php?users");
    }

}



function  get_reports()
{
    $query = query("SELECT * FROM reports");
    confirm($query);

    while($row = fetch_array($query))
    {
        $report = <<<DELIMETER

        <tr>
            <td>{$row['report_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['report_price']}</td>
            <td>{$row['product_title']}</td>
            <td>{$row['report_quantity']}</td>
            <td>
                <a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </td>
        </tr>

DELIMETER;
    
        echo $report;
    }
}


function dashboard_transaction_date()
{
    $query = query("SELECT * FROM orders ORDER BY order_date DESC");
    confirm($query);

    while($row = fetch_array($query))
    {
        $order = <<<DELIMETER

        <tr>
            <td>{$row['order_id']}</td>
            <td>{$row['order_date']}</td>
            <td>{$row['order_amount']}</td>
            <td>{$row['order_currency']}</td>
        </tr>

DELIMETER;
    
        echo $order;
    }
}


function dashboard_transaction_amount()
{
    $query = query("SELECT * FROM orders ORDER BY order_amount DESC");
    confirm($query);

    while($row = fetch_array($query))
    {
        $order = <<<DELIMETER

        <tr>
            <td>{$row['order_id']}</td>
            <td>{$row['order_date']}</td>
            <td>{$row['order_amount']}</td>
            <td>{$row['order_currency']}</td>
        </tr>

DELIMETER;
    
        echo $order;
    }
}



function num_of_orders()
{
    $query = query("SELECT * FROM orders");
    confirm($query);
    $num_oerders = pg_num_rows($query);
    echo $num_oerders;
}


function num_of_products()
{
    $query = query("SELECT * FROM products");
    confirm($query);
    $num_products = pg_num_rows($query);
    echo $num_products;
}


function num_of_categories()
{
    $query = query("SELECT * FROM ecategories");
    confirm($query);
    $num_cat = pg_num_rows($query);
    echo $num_cat;
}


function add_reviews()
{
    if(isset($_POST['add_review']))
    {
       // product_id !!! 
        $review_name   = escape_string($_POST['review_name']);
        $review_email  = escape_string($_POST['review_email']);
        $review_text   = escape_string($_POST['review_text']);
        $raiting       = escape_string($_POST['raiting']);
  
        $query = query("INSERT INTO reviews (review_name, review_email, review_text, raiting, review_date)
                            VALUES('{$review_name}', '{$review_email}', '{$review_text}', '{$raiting}', current_date)");                
        confirm($query);

        set_message("Review added");
        redirect("index.php?shop");

    }

}



function show_reviews()
{
    $query = query("SELECT * FROM reviews");
    confirm($query);

    while($row = fetch_array($query))
    {

        $raiting = $row['raiting'];

        if($raiting == 5)
        {
        $html_stars = '<span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>';
        }   
        else if($raiting == 4)
        {
            $html_stars = '<span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>';
        }   
        else if($raiting == 3)
        {
            $html_stars = '<span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>';
        }   
        else if($raiting == 2)
        {
            $html_stars = '<span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>';
        }   
        else if($raiting == 1)
        {
            $html_stars = '<span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>';
        }   

        $order = <<<DELIMETER
    
        <div class="row">
            <div class="col-md-12">
                    $html_stars
                    {$row['review_name']}
                <span class="pull-right">{$row['review_date']}</span>
                <p>{$row['review_text']}</p>
            </div>
        </div>
        <hr/>

DELIMETER;
    
        echo $order;
    }

}



function avg_star()
{
    $query = query("SELECT avg(raiting) FROM reviews");
    confirm($query);

    $avg_raiting_arr = fetch_array($query);
    $avg_raiting = $avg_raiting_arr['avg'];
    $avg_raiting = round($avg_raiting, 2);

            if($avg_raiting <= 5 & $avg_raiting > 4)
            {
                $html_star = '<div class="ratings">
                            <p>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                '.$avg_raiting.' stars
                            </p>
                        </div>';
            }
            else if($avg_raiting <= 4 & $avg_raiting > 3)
            {
                $html_star = '<div class="ratings">
                            <p>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                                '.$avg_raiting.' stars 
                            </p>
                        </div>';
            }
            else if($avg_raiting <= 3 & $avg_raiting > 2)
            {
                $html_star = '<div class="ratings">
                            <p>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                                '.$avg_raiting.' stars  
                            </p>
                        </div>';
            }
            else if($avg_raiting <= 2 & $avg_raiting > 1)
            {
                $html_star = '<div class="ratings">
                            <p>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                                '.$avg_raiting.' stars
                            </p>
                        </div>';
            }
            else
            {
                $html_star = '<div class="ratings">
                            <p>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                                '.$avg_raiting.' stars
                            </p>
                        </div>';
            }

    echo $html_star;

}


// ********** MARKO MARKOVIC ************



