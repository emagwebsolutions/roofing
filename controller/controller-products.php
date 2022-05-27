<?php
class products{

    public function categories(){
        $qry = DB::query("SELECT * FROM categories");
        echo json_encode($qry);
    }

    
    public function add_product(){
        $prod_name = $_POST['prod_name'];
        $package = $_POST['package'];
        $prod_qty = $_POST['prod_qty'];
        $selling_price = $_POST['selling_price'];
        $cat_id = $_POST['cat_id'];
        $date = $_POST['date'];

        //Check if product exist
        $slct = DB::query("SELECT prod_name FROM products WHERE prod_name = ? 
        ", array($prod_name));
        if(!empty($slct)){
            template::output(false, 'Product Name already exist!');
        }

        validation::empty_validation(array(
            'Product Name' => $prod_name,
            'Product Price' => $selling_price,
            'Category' => $cat_id
        ));

        validation::string_validation(array(
            'Product Name' => $prod_name,
            'Product Price' => $selling_price
        ));

		//Proforma date validation
		$pdate = date("Y-m-d", strtotime($date)).' '.date('H:i:s');
		validation::date_validation($pdate, 'Product Date field required!');
        
        DB::query("INSERT INTO 
        products(	
            prod_name,
            cat_id,
            selling_price,
            date,
            package,
            prod_qty
        ) 
        
        VALUES(?, ?, ?, ?,?,?)",array(
            strtoupper($prod_name),
            $cat_id,
            $selling_price,
            $pdate,
            $package,
            $prod_qty
        ));

        echo 'Product added successfully!';

    }


    public function update_product(){
        $prod_name = $_POST['prod_name'];
        $selling_price = $_POST['selling_price'];
        $package = $_POST['package'];
        $prodqty = $_POST['prod_qty'];
        $cat_id = $_POST['cat_id'];
        $prod_id = $_POST['prod_id'];
        $date = $_POST['date'];

        $qryt = DB::get_row("SELECT prod_qty FROM products WHERE prod_id = ?",array($prod_id));
        if($qryt['prod_qty']){
            $prod_qty =  intval($qryt['prod_qty']) + intval($prodqty);
        }
        else{
            $prod_qty = $prodqty;
        }

        validation::empty_validation(array(
            'Product Name' => $prod_name,
            'Product Price' => $selling_price,
            'Category' => $cat_id
        ));


        validation::string_validation(array(
            'Product Name' => $prod_name,
            'Product Price' => $selling_price
        ));
        
		
        
		//Proforma date validation
		$pdate = date("Y-m-d", strtotime($date)).' '.date('H:i:s');
		validation::date_validation($pdate, 'Product Date field required!');

        DB::query("
        UPDATE products SET
            prod_name = ?,
            cat_id = ?,
            selling_price = ?,
            updated_on = ?,
            package=?,
            prod_qty =?
            WHERE prod_id = ?
            "
            ,array(
            strtoupper($prod_name),
            $cat_id,
            $selling_price,
            $pdate,
            $package,
            $prod_qty,
            $prod_id
        ));

    
        echo 'Product updated successfully!';

    }



    public function get_sales(){
        $qry = DB::query("SELECT s.prod_id,s.project,s.qty,s.date,s.exp_date, c.phone,s.invoice_no,c.email,c.fullname, c.location FROM sales as s JOIN customers as c ON s.cust_id = c.cust_id WHERE s.trans_type = 'invoice' ");
        echo json_encode($qry);
    }




    public function delete_product(){
        $prod_id = $_GET['prod_id'];
        DB::query('DELETE FROM products WHERE prod_id = ?', array($prod_id));
    }

    public function delete_category(){
        $cat_id = $_GET['cat_id'];
        DB::query('DELETE FROM category WHERE cat_id = ?', array($cat_id));
        $qry = DB::query('SELECT * FROM category');
        $jsn = json_encode($qry);
        file_put_contents('assets/json/categories.json', $jsn);
    }



    public function product_pdf_json(){
        file_put_contents('assets/json/product-pdf-jsn.json', $_POST['data']);
    }


    public function add_category(){
        $cat = strtoupper($_POST['cat']);

        $qry = DB::query("SELECT cat_name FROM category WHERE cat_name = ?", array($cat));
        if(!empty($qry)){
            template::output(false, 'Category alread exist!');
        }

        validation::empty_validation(array(
            "Category" => $cat
        ));
        validation::string_validation(array("Category" => $cat));

        DB::query("INSERT INTO category(cat_name, ref) VALUES(?,'product')", array($cat));

        $qry = DB::query("SELECT * FROM category ORDER BY cat_name");
        $jsn = json_encode($qry);
        file_put_contents('assets/json/categories.json', $jsn);

        echo 'Category added successfully!';
    }



    public function update_category(){
        $cat = strtoupper($_POST['cat']);
        $cat_id = strtoupper($_POST['cat_id']);
        validation::empty_validation(array(
            "Category" => $cat
        ));
        validation::string_validation(array("Category" => $cat));

        DB::query("UPDATE category SET cat_name =? WHERE cat_id =?", array($cat, $cat_id));
        echo 'Category added successfully!';
    }


    public function all_products(){
        $qry = DB::query("SELECT * FROM products");
        echo json_encode($qry);
    }

    public function single_product(){
        $prod_id = $_GET['prod_id'];
        $qry = DB::query("SELECT * FROM products WHERE prod_id =?",array($prod_id));
        echo json_encode($qry);
    }

    public function create_prod_file(){
        $data = $_POST['data'];
        file_put_contents(dirname(__DIR__).'/assets/pdf/images/genProducts.txt', $data);
        echo 'Completed';
    }

		
}
