<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Product_model extends CI_Model
{
	//product
    function addtowishlist($user,$product)
    {
        $query=$this->db->query("INSERT INTO `userwishlist`(`user`,`product`) VALUES ('$user','$product')");
        return $query;
    }
    public function createnewblue($product)
    {
        $query="SELECT * FROM `productcategory`   WHERE `category`=31 AND `product`=$product";
        $querycount=$this->db->query("SELECT * FROM `productcategory`   WHERE `category`=31")->result();
        
        $select=$this->db->query($query)->result();
        $count=count($querycount);
        if($count >= 30)
        {
            return 0;
        }
        else
        {
            if(empty($select))
            {
                $data=array(
                   'category' => 31,
                    'product'=>$product
                );
                $query=$this->db->insert('productcategory',$data);
                return 1;
            }
            else
            {
                return 0;
            }
    //		$id=$this->db->insert_id();
        }

    }
	public function createproduct($name,$sku,$description,$url,$visibility,$price,$wholesaleprice,$firstsaleprice,$secondsaleprice,$specialpricefrom,$specialpriceto,$metatitle,$metadesc,$metakeyword,$quantity,$status,$category,$relatedproduct)
	{
		$data  = array(
			'name' => $name,
			'sku' => $sku,
			'description' => $description,
			'url' => $url,
			'visibility' => $visibility,
			'price' => $price,
			'wholesaleprice' => $wholesaleprice,
			'firstsaleprice' => $firstsaleprice,
			'secondsaleprice' => $secondsaleprice,
			'specialpricefrom' => $specialpricefrom,
			'specialpriceto' => $specialpriceto,
			'metatitle' => $metatitle,
			'metadesc' => $metadesc,
			'metakeyword' => $metakeyword,
			'quantity' => $quantity,
			'status' => $status,
		);
		$query=$this->db->insert( 'product', $data );
		$id=$this->db->insert_id();

//        $mysession["id"]=$id;
//        $this->session->set_userdata($mysession);
        if(!empty($category))
		{
			foreach($category as $key => $cat)
			{
				$data1  = array(
					'product' => $id,
					'category' => $cat,
				);
				$query=$this->db->insert( 'productcategory', $data1 );
			}
		}
		if($query)
		{
			$this->saveproductlog($id,"Product Created");
		}
		/*
		if(!empty($relatedproduct))
		{
			foreach($relatedproduct as $key => $pro)
			{
				$data2  = array(
					'product' => $id,
					'relatedproduct' => $pro,
				);
				$query=$this->db->insert( 'relatedproduct', $data2 );
			}
		}*/
		return  $id;
	}
    function deleteall($id)
    {

        foreach($id as $idu)
        {
            $query=$this->db->query("DELETE FROM `product` WHERE `id`='$idu'");
        }
        if($query){
            return 1;
        }else{
            return 0;
        }
    }
	function viewproduct()
	{
	$query=$this->db->query("SELECT `product`.`id`,`product`.`name`,`product`.`sku`,`product`.`price`,`product`.`quantity` FROM `product`
		ORDER BY `product`.`id` ASC")->result();
		return $query;
	}
    function viewnewblue()
	{
	$query=$this->db->query("SELECT `productcategory`.`product`, `productcategory`.`category` ,`product`.`name` AS `productname` FROM `productcategory` LEFT OUTER JOIN `product` ON `product`.`id`=`productcategory`.`product` WHERE `productcategory`.`category`=31")->result();
		return $query;
	}
	public function beforeeditproduct( $id )
	{
		$this->db->where( 'id', $id );
		$query['product']=$this->db->get( 'product' )->row();
		$product_category=$this->db->query("SELECT `category` FROM `productcategory` WHERE `productcategory`.`product`='$id'")->result();
		$query['product_category']=array();
		foreach($product_category as $cat)
		{
			$query['product_category'][]=$cat->category;
		}
		$related_product=$this->db->query("SELECT `relatedproduct` FROM `relatedproduct` WHERE `relatedproduct`.`product`='$id'")->result();
		$query['related_product']=array();
		foreach($related_product as $pro)
		{
			$query['related_product'][]=$pro->relatedproduct;
		}
		return $query;
	}

	public function editproduct( $id,$name,$sku,$description,$url,$visibility,$price,$wholesaleprice,$firstsaleprice,$secondsaleprice,$specialpricefrom,$specialpriceto,$metatitle,$metadesc,$metakeyword,$quantity,$status,$category,$relatedproduct)
	{
		$data = array(
			'name' => $name,
			'sku' => $sku,
			'description' => $description,
			'url' => $url,
			'visibility' => $visibility,
			'price' => $price,
			'wholesaleprice' => $wholesaleprice,
			'firstsaleprice' => $firstsaleprice,
			'secondsaleprice' => $secondsaleprice,
			'specialpricefrom' => $specialpricefrom,
			'specialpriceto' => $specialpriceto,
			'metatitle' => $metatitle,
			'metadesc' => $metadesc,
			'metakeyword' => $metakeyword,
			'quantity' => $quantity,
			'status' => $status,
		);
		$this->db->where( 'id', $id );
		$q=$this->db->update( 'product', $data );
		$this->db->query("DELETE FROM `productcategory` WHERE `product`='$id'");
		$this->db->query("DELETE FROM `relatedproduct` WHERE `product`='$id'");
		if(!empty($category))
		{
			foreach($category as $key => $cat)
			{
				$data1  = array(
					'product' => $id,
					'category' => $cat,
				);
				$query=$this->db->insert( 'productcategory', $data1 );
			}
		}
		if($q)
		{
			$this->saveproductlog($id,"Product Details Edited");
		}
		/*
		if(!empty($relatedproduct))
		{
			foreach($relatedproduct as $key => $pro)
			{
				$data2  = array(
					'product' => $id,
					'relatedproduct' => $pro,
				);
				$query=$this->db->insert( 'relatedproduct', $data2 );
			}
		}*/

		return 1;
	}
	function deleteproduct($id)
	{
		$query=$this->db->query("DELETE FROM `product` WHERE `id`='$id'");
		$this->db->query("DELETE FROM `productcategory` WHERE `product`='$id'");
		$this->db->query("DELETE FROM `relatedproduct` WHERE `product`='$id'");
	}
    	function deletenewblue($id,$productcat)
	{

		$this->db->query("DELETE FROM `productcategory` WHERE `category`='$id'  AND  `product`='$productcat' ");

	}
	public function getcategorydropdown()
	{
		$query=$this->db->query("SELECT * FROM `category`  ORDER BY `id` ASC")->result();
		$return=array(

		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}

		return $return;
	}
	public function getproductdropdown()
	{
		$query=$this->db->query("SELECT * FROM `product`  ORDER BY `id` ASC")->result();
		$return=array(

		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}

		return $return;
	}

	public function getstatusdropdown()
	{
		$status= array(
			 "1" => "Enabled",
			 "0" => "Disabled",
			);
		return $status;
	}
	public function getvisibility()
	{
		$status= array(
			 "1" => "Yes",
			 "0" => "No",
			);
		return $status;
	}
	function viewallimages($id)
	{
		$query=$this->db->query(" SELECT `productimage`.`id` as `id`, `productimage`.`image` as `productimage`,`productimage`.`product` as `productid`,`productimage`.`is_default` as `is_default`,`productimage`.`order` as `order`  FROM `productimage` WHERE `productimage`.`product`='$id' ORDER BY `productimage`.`order` ")->result();
		return $query;
	}
	function addimage($id,$uploaddata)
	{
		$productimage	= $uploaddata[ 'file_name' ];
		$path = $uploaddata[ 'full_path' ];
		$nextorder=$this->db->query("SELECT IFNULL(MAX(`order`)+1,0) AS `nextorder` FROM `productimage` WHERE `product`='$id'")->row();
		$nextorder= $nextorder->nextorder;

		if($nextorder=="0")
		$isdefault="1";
		else
		$isdefault="0";
		$data  = array(
			'image' => $productimage,
			'product' => $id,
			'is_default' => $isdefault,
			'order' => $nextorder,
			);
		$query=$this->db->insert( 'productimage', $data );
		if($query)
		{
			$this->saveproductlog($id,"Product Image Added");
		}

	}
	function deleteimage($productimageid,$id)
	{
		$query=$this->db->query("DELETE FROM `productimage` WHERE `product`='$id' AND `id`='$productimageid'");
		if($query)
		{
			$this->saveproductlog($id,"Product Image Deleted");
		}
	}
	function defaultimage($productimageid,$id)
	{
		$order=$this->db->query("SELECT `order` FROM `productimage` WHERE `id`='$productimageid'")->row();
		$order=$order->order;

		$this->db->query(" UPDATE `productimage` SET `order`='$order' WHERE `is_default`='1' ");
		$this->db->query(" UPDATE `productimage` SET `is_default`='0' WHERE `productimage`.`product`='$id' ");

		$query=$this->db->query(" UPDATE `productimage` SET `is_default`='1',`order`='0' WHERE `productimage`.`id`='$productimageid' AND `productimage`.`product`='$id' ");
		if($query)
		{
			$this->saveproductlog($id,"Product Image set to default");
		}
	}
	function changeorder($productimageid,$order,$product)
	{
		$query=$this->db->query("UPDATE `productimage` SET `order`='$order' WHERE `id`='$productimageid' ");
		if($query)
		{
			$this->saveproductlog($product,"Product Image Order Edited");
		}
	}
	function savequantity($product,$quantity)
	{
		$data = array(
			'quantity' => $quantity,
		);
		$this->db->where( 'id', $product );
		$query=$this->db->update( 'product', $data );

		if($query)
		{
			$this->saveproductlog($product,"Product Quantity Updated ,Quantity:$quantity");
		}
		if($query)
			return 1;
		else
			return 0;
	}
	function editprice($id,$price,$wholesaleprice,$firstsaleprice,$secondsaleprice,$specialpricefrom,$specialpriceto)
	{
		$data = array(
			'price' => $price,
			'wholesaleprice' => $wholesaleprice,
			'firstsaleprice' => $firstsaleprice,
			'secondsaleprice' => $secondsaleprice,
			'specialpricefrom' => $specialpricefrom,
			'specialpriceto' => $specialpriceto,

		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'product', $data );
		if($query)
		{
			$this->saveproductlog($id,"Product Price Edited");
		}
		return 1;
	}
	function editrelatedproduct($id,$relatedproduct)
	{
		$this->db->query("DELETE FROM `relatedproduct` WHERE `product`='$id'");

		if(!empty($relatedproduct))
		{
			foreach($relatedproduct as $key => $pro)
			{
				$data2  = array(
					'product' => $id,
					'relatedproduct' => $pro,
				);
				$query=$this->db->insert( 'relatedproduct', $data2 );
			}
		}

		{
			$this->saveproductlog($id,"Related Product updated");
		}
		return 1;
	}
	public function getproducts($product)
	{
		$query=$this->db->query("SELECT `id`,`name` FROM `product` WHERE `id` NOT IN ($product)  ORDER BY `id` ASC")->result();


		return $query;
	}
	function viewproductwaiting($product)
	{
		$query=$this->db->query("SELECT `user`.`firstname`,`user`.`lastname`,`productwaiting`.`email`,`productwaiting`.`timestamp`,`productwaiting`.`id` as `id` FROM `productwaiting`
		LEFT JOIN `user` ON `user`.`id`=`productwaiting`.`user`
		ORDER BY `productwaiting`.`timestamp` DESC")->result();
		return $query;
	}
	function saveproductlog($id,$action)
	{
		$user = $this->session->userdata('id');
		$data2  = array(
			'product' => $id,
			'user' => $user,
			'action' => $action,
		);
		$query2=$this->db->insert( 'productlog', $data2 );
	}
	function getproductbycategory($category,$color,$price1,$price2)
	{
//        echo $category;
		$getcategoryidbyname=$this->db->query("SELECT * FROM `category` WHERE `name`LIKE '$category'")->row();
        $category=$getcategoryidbyname->id;
		$where = "";
		if($price1!="")
		{
		$pricefilter="AND (`product`.`price` BETWEEN $price1 AND $price2 OR `product`.`price`=$price1 OR `product`.`price`=$price2)";
		}
		else
		{
		$pricefilter="";
		}
		$q3 = $this->db->query("SELECT COUNT(*) as `cnt` FROM `category` WHERE `category`.`parent`= '$category'")->row();
		if($q3->cnt > 0)
			$where .= " OR `category`.`parent`='$category' ";
		$query['category']=$this->db->query("SELECT `category`.`name` ,`category`.`image1` FROM `category`
		WHERE `category`.`id`='$category'")->row();



		$query['product']=$this->db->query("SELECT `product`.`id`,`product`.`name`,`product`.`description`,`product`.`sku`,`product`.`url`,`product`.`price`,`product`.`wholesaleprice`,`product`.`firstsaleprice`,`product`.`secondsaleprice`,`product`.`specialpriceto`,`product`.`specialpricefrom`,`productimage`.`image` FROM `product`
		INNER JOIN `productcategory` ON `product`.`id`=`productcategory`.`product`
		INNER JOIN `category` ON `category`.`id`=`productcategory`.`category`
		LEFT JOIN `productimage` ON `productimage`.`product`=`product`.`id`
		WHERE `product`.`visibility`=1 AND `product`.`status`=1 AND `product`.`quantity` >= 0 AND `product`.`name` LIKE '%$color%' $pricefilter
        AND (   `productcategory`.`category`=$category $where )
		GROUP BY `product`.`id`
		ORDER BY `product`.`id` DESC")->result();

		foreach($query['product'] as $p_row)
		{
			$productid = $p_row->id;
			$p_row->productimage=$this->db->query("SELECT `productimage`.`image` FROM `productimage`
			WHERE `productimage`.`product`='$productid'
			ORDER BY `productimage`.`order`
			LIMIT 0,2")->result();
		}
		foreach($query['product'] as $p_row)
		{
			$productid = $p_row->id;
			$query5=$this->db->query("SELECT count(`category`) as `isnew`  FROM `productcategory`
			WHERE  `productcategory`.`category`='31' AND `product`='$productid'
			LIMIT 0,1")->row();
			$p_row->isnew=$query5->isnew;

		}
		/*$query['subcategory']=$this->db->query("SELECT `category`.`name`,`category`.`image1`,`category`.`image2` FROM `category`
		WHERE `category`.`parent`='$category' AND `category`.`status`=1
		ORDER BY `category`.`order`")->result();*/
		$query['subcategory'] = $this->db->query("SELECT `tab1`.`id`,`tab1`.`name`,`tab1`.`image1`,`tab1`.`image2`,COUNT(`tab2`.`id`) as `cnt` FROM
		(
		SELECT `category`.`name`,`category`.`id`,`category`.`image1`,`category`.`image2`,`category`.`order` FROM `category`
			WHERE `category`.`parent`='$category' AND `category`.`status`=1
		) as `tab1`
		INNER JOIN `productcategory` ON `productcategory`.`category`=`tab1`.`id`
		INNER JOIN `product`  as `tab2` ON `productcategory`.`product`=`tab2`.`id` AND `tab2`.`status`=1
		GROUP BY `tab1`.`id`
		ORDER BY `tab1`.`order` ")->result();
		$query['template']=new StdClass();
		$query['breadcrumbs']=$this->getparentcategories($category);
		$query['currentcategory']=$category;
		$query['template']->pageurl = "partials/product.html";
		return $query;
	}
	function getproductdetails($product,$category)
	{
		$query['breadcrumbs']=$this->getparentcategories($category);
		$query['product']=$this->db->query("SELECT `product`.`id`,`product`.`name`,`product`.`sku`,`product`.`url`,`product`.`price`,`product`.`wholesaleprice`,`product`.`description`,`product`.`firstsaleprice`,`product`.`secondsaleprice`,`product`.`specialpriceto`,`product`.`specialpricefrom`,`product`.`quantity` FROM `product`
		WHERE `product`.`id`='$product'")->row();



			$query5=$this->db->query("SELECT count(`category`) as `isnew`  FROM `productcategory`
			WHERE  `productcategory`.`category`='31' AND `product`='$product'
			LIMIT 0,1")->row();
			$query['product']->isnew=$query5->isnew;



		$query['productimage'] = $this->db->query("SELECT `image` ,`productimage`.`order` FROM `productimage`
		WHERE `product`='$product'
		ORDER BY `productimage`.`order`")->result();

		$query['relatedproduct']=$this->db->query("SELECT `product`.`id`,`product`.`name`,`product`.`sku`,`product`.`url`,`product`.`price`,`product`.`wholesaleprice`,`product`.`firstsaleprice`,`product`.`secondsaleprice`,`product`.`specialpriceto`,`product`.`specialpricefrom`,`product`.`quantity`,`productimage`.`image` FROM `relatedproduct`
		INNER JOIN `product` ON `product`.`id`=`relatedproduct`.`relatedproduct` AND `relatedproduct`.`product`='$product' AND `product`.`visibility`=1 AND `product`.`status`=1 AND `product`.`quantity` > 0
		INNER JOIN `productimage` ON `productimage`.`id`=`product`.`id`
		GROUP BY `product`.`id`
		ORDER BY `productimage`.`order`")->result();

		//for product view log
        $userid=$this->session->userdata('id');
        $this->db->query("INSERT INTO `productviewlog`(`product`, `user`, `timestamp`) VALUES ('$product','$userid',NULL)");

		return $query;
	}
	public function getchildrencategories($category)
	{
		$children=array();
		$children[]=$category;
		$query=$this->db->query("SELECT `id` as `children` FROM `category` WHERE `category`.`parent`='$category' ");
		if ( $query->num_rows() <= 0 ) {
			return $children;
		}
		else {

			$query=$query->result();
			//print_r($query);
			foreach($query as $row)
			{
				$other=array();
				$other=$this->getchildrencategories($row->children);
				$children=array_merge($children, $other);

			}
			return $children;
		}
	}
	public function getparentcategories($categoryid)
	{
		$parents=array();
		$q = $this->db->query("SELECT `name` FROM `category` WHERE `id`='$categoryid'")->row();
        $c=new stdClass();
		$c->id=$categoryid;
		$c->name=$q->name;

		do
		{
			$row=$this->db->query("SELECT `category`.`parent` as `category`,`tab2`.`name` FROM `category`
			LEFT JOIN `category` as `tab2` ON `category`.`parent`=`tab2`.`id`
			WHERE `category`.`id`='$categoryid'")->row();
			//echo ($row->category);
			$category = new StdClass();
			$category->id=$row->category;
			$category->name=$row->name;
			if($row->category != 0 || $row->category != "0")
			{

				array_push($parents,$category);
			}
			$categoryid = $row->category;

		}while($categoryid!=0) ;
		//$parents[]=$c;
		array_push($parents,$c);

		return $parents;
	}
    public function addproductwaitinglist($email,$product)
    {
        $this->db->query("INSERT INTO `productwaiting`(`email`,`user`,`product`) VALUES ('$email','','$product')");
        return true;
    }

	public function beforeeditproductwaiting( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'productwaiting' )->row();
		return $query;
	}
   public function editproductwaiting($id,$product,$user,$email)
	{
		$data = array(
			'product' => $product,
			'user' => $user,
			'email' => $email,
			'timestamp' => NULL
		);
		$this->db->where( 'id', $id );
		$q=$this->db->update( 'productwaiting', $data );

		return 1;
	}

	function deleteproductwaiting($id)
	{
		$query=$this->db->query("DELETE FROM `productwaiting` WHERE `id`='$id'");
	}

    function exportproductcsv()
	{
        
		$this->load->dbutil();
		$query=$this->db->query("SELECT  `product`.`id`  AS `id` ,  `product`.`name`  AS `name` ,  `product`.`sku`  AS `sku` ,  `product`.`url`  AS `url` ,  `product`.`price`  AS `price` ,  `product`.`wholesaleprice`  AS `wholesaleprice` ,  `product`.`firstsaleprice`  AS `firstsaleprice` ,  `product`.`secondsaleprice`  AS `secondsaleprice` ,  `product`.`specialpriceto`  AS `specialpriceto` ,  `product`.`specialpricefrom`  AS `specialpricefrom` , GROUP_CONCAT(`productimage`.`image`) AS `image`, GROUP_CONCAT(`category`.`name`) AS `category`, `product`.`quantity`  AS `quantity` 
FROM `product` 
INNER JOIN `productcategory` ON `product`.`id`=`productcategory`.`product` 
INNER JOIN `category` ON `category`.`id`=`productcategory`.`category` 
LEFT OUTER JOIN `productimage` ON `productimage`.`product`=`product`.`id` 
GROUP BY `product`.`id` ORDER BY  `product`.`id` DESC");

       $content= $this->dbutil->csv_from_result($query);
        //$data = 'Some file data';
$timestamp=new DateTime();
        $timestamp=$timestamp->format('Y-m-d_H.i.s');
//        file_put_contents("gs://magicmirroruploads/products_$timestamp.csv", $content);
//		redirect("http://magicmirror.in/servepublic?name=products_$timestamp.csv", 'refresh');
        
		file_put_contents("gs://lylafiles/product_$timestamp.csv", $content);
		redirect("http://lylaloves.co.uk/servepublic?name=product_$timestamp.csv", 'refresh');
        
//		$this->load->dbutil();
//		$query=$this->db->query("SELECT `product`.`id`AS `Parentid`,`product`.`id`AS `Productid`, `product`.`name`,CONCAT('http://www.lylaloves.co.uk/#/product/',`product`.`id`) as `Permalink` ,CONCAT('http://www.lylaloves.co.uk/#/product/',`productimage`.`image`) as `ImageURL` ,`product`.`description`,'0000-00-00' AS 'productpublished','0000-00-00' AS 'productmodified','Item' AS 'Type', `product`.`price`,`category`.`name` AS `Category`,`product`. `quantity` ,'NO' AS 'Allow Backorders'
//FROM `product`
//LEFT OUTER JOIN `productimage` ON `productimage`.`product`=`product`.`id`
//LEFT OUTER JOIN `productcategory` ON `productcategory`.`product`=`product`.`id`
//LEFT OUTER JOIN `category` ON `productcategory`.`category`=`category`.`id`");
//
//       $content= $this->dbutil->csv_from_result($query);
//        //$data = 'Some file data';
//
//        if ( ! write_file('./csvgenerated/productfile.csv', $content))
//        {
//             echo 'Unable to write the file';
//        }
//        else
//        {
//            redirect(base_url('csvgenerated/productfile.csv'), 'refresh');
//             echo 'File written!';
//        }
//		file_put_contents("gs://lylafiles/product_$timestamp.csv", $content);
//		redirect("http://lylaloves.co.uk/servepublic?name=product_$timestamp.csv", 'refresh');
	}
    
//    function exportproductcsv()
//	{
//		$this->load->dbutil();
//		$query=$this->db->query("SELECT  `product`.`id`  AS `id` ,  `product`.`name`  AS `name` ,  `product`.`sku`  AS `sku` ,  `product`.`url`  AS `url` ,  `product`.`price`  AS `price` ,  `product`.`wholesaleprice`  AS `wholesaleprice` ,  `product`.`firstsaleprice`  AS `firstsaleprice` ,  `product`.`secondsaleprice`  AS `secondsaleprice` ,  `product`.`specialpriceto`  AS `specialpriceto` ,  `product`.`specialpricefrom`  AS `specialpricefrom` , GROUP_CONCAT(`productimage`.`image`) AS `image`, GROUP_CONCAT(`category`.`name`) AS `category`, `product`.`quantity`  AS `quantity` 
//FROM `product` 
//INNER JOIN `productcategory` ON `product`.`id`=`productcategory`.`product` 
//INNER JOIN `category` ON `category`.`id`=`productcategory`.`category` 
//LEFT OUTER JOIN `productimage` ON `productimage`.`product`=`product`.`id` 
//GROUP BY `product`.`id` ORDER BY  `product`.`id` DESC");
//
//       $content= $this->dbutil->csv_from_result($query);
//        //$data = 'Some file data';
//$timestamp=new DateTime();
//        $timestamp=$timestamp->format('Y-m-d_H.i.s');
//        file_put_contents("gs://magicmirroruploads/products_$timestamp.csv", $content);
//		redirect("http://magicmirror.in/servepublic?name=products_$timestamp.csv", 'refresh');
////        if ( ! write_file('./csvgenerated/productfile.csv', $content))
////        {
////             echo 'Unable to write the file';
////        }
////        else
////        {
////            redirect(base_url('csvgenerated/productfile.csv'), 'refresh');
////             echo 'File written!';
////        }
////		file_put_contents("gs://lylafiles/product_$timestamp.csv", $content);
////		redirect("http://lylaloves.co.uk/servepublic?name=product_$timestamp.csv", 'refresh');
//	}

	public function createbycsv($file)
	{
        foreach ($file as $row)
        {

            if($row['specialpricefrom'] != "")
				$specialpricefrom = date("Y-m-d",strtotime($row['specialpricefrom']));
			if($row['specialpriceto'] != "")
				$specialpriceto = date("Y-m-d",strtotime($row['specialpriceto']));
            $sku=$row['sku'];
            $productfeatures=$row['productfeatures'];
            $image=$row['image'];
            $allimages=explode(",",$image);
            $category=$row['category'];
            $allcategories=explode(",",$category);

            $category=$row['category'];
            $data  = array(
                'name' => $row['name'],
                'sku' => $row['sku'],
                'description' => $row['description'],
                'url' => $row['url'],
                'metatitle' => $row['metatitle'],
                'metadesc' => $row['metadescription'],
                'metakeyword' => $row['metakeyword'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
                'wholesaleprice' => $row['wholesaleprice'],
                'firstsaleprice' => $row['firstsaleprice'],
                'secondsaleprice' => $row['secondsaleprice'],
                'specialpricefrom' => $specialpricefrom,
                'specialpriceto' => $specialpriceto,
                'status' => 1
            );
            $checkproductpresent=$this->db->query("SELECT COUNT(`id`) as `count1` FROM `product` WHERE `sku`='$sku'")->row();
//            print_r($data);
            if($checkproductpresent->count1 == 0)
            {
                $query=$this->db->insert( 'product', $data );
                $productid=$this->db->insert_id();
            }

			foreach($allimages as $key => $image)
			{
				$data1  = array(
					'product' => $productid,
					'image' => $image,
				);
				$queryproductimage=$this->db->insert( 'productimage', $data1 );
			}

			foreach($allcategories as $key => $category)
			{
                $categoryquery=$this->db->query("SELECT * FROM `category` where `name`LIKE '$category'")->row();
                if(empty($categoryquery))
                {
                    $this->db->query("INSERT INTO `category`(`name`) VALUES ('$category')");
                    $categoryid=$this->db->insert_id();
                }
                else
                {
                    $categoryid=$categoryquery->id;
                }

				$data2  = array(
					'product' => $productid,
					'category' => $categoryid,
				);
				$queryproductimage=$this->db->insert( 'productcategory', $data2 );
			}
        }

//        foreach ($file as $row)
//        {
//
//            if($row['specialpricefrom'] != "")
//				$specialpricefrom = date("Y-m-d",strtotime($row['specialpricefrom']));
//			if($row['specialpriceto'] != "")
//				$specialpriceto = date("Y-m-d",strtotime($row['specialpriceto']));
//            $sku=$row['sku'];
//            $data  = array(
//                'name' => $row['name'],
//                'sku' => $row['sku'],
//                'description' => $row['description'],
//                'url' => $row['url'],
//                'metatitle' => $row['metatitle'],
//                'metadesc' => $row['metadescription'],
//                'metakeyword' => $row['metakeyword'],
//                'quantity' => $row['quantity'],
//                'price' => $row['price'],
//                'wholesaleprice' => $row['wholesaleprice'],
//                'firstsaleprice' => $row['firstsaleprice'],
//                'secondsaleprice' => $row['secondsaleprice'],
//                'specialpricefrom' => $specialpricefrom,
//                'specialpriceto' => $specialpriceto,
//                'status' => 1
//            );
//            $checkproductpresent=$this->db->query("SELECT COUNT(`id`) as `count1` FROM `product` WHERE `sku`='$sku'")->row();
//            if($checkproductpresent->count1 == 0)
//            {
//            $query=$this->db->insert( 'product', $data );
//            }
//        }
		if(!$query)
			return  0;
		else
			return  1;
	}
    public function productcat()
    {
       	$query=$this->db->query("SELECT `category` FROM `productcategory`   WHERE `productcategory`.`product`='31' ")->result();
		return $query;

    }


	function gettoptenproductsearchmonth()
	{
		$query=$this->db->query("SELECT COUNT(`productsearchlog`.`product`) AS `count1`,`productsearchlog`. `id`, `productsearchlog`. `product`, `productsearchlog`. `user`, `productsearchlog`. `timestamp` ,`product`.`name` AS `productname`,YEAR(`productsearchlog`. `timestamp`),`productimage`.`image`

FROM `productsearchlog`
LEFT OUTER JOIN `product` ON `product`.`id`=`productsearchlog`. `product` INNER JOIN `productimage` ON `productimage`.`product`= `productsearchlog`. `product`

WHERE YEAR(NOW())=YEAR(`productsearchlog`. `timestamp`)
GROUP BY `productsearchlog`.`product`
ORDER BY `count1` DESC
LIMIT 0 , 10")->result();
		return $query;
	}
	function gettoptenproductsearchyear()
	{
		$query=$this->db->query("SELECT COUNT(`productsearchlog`.`product`) AS `count1`,`productsearchlog`. `id`, `productsearchlog`. `product`, `productsearchlog`. `user`, `productsearchlog`. `timestamp` ,`product`.`name` AS `productname`,MONTH(`productsearchlog`. `timestamp`),`productimage`.`image`
FROM `productsearchlog`
LEFT OUTER JOIN `product` ON `product`.`id`=`productsearchlog`. `product` INNER JOIN `productimage` ON `productimage`.`product`= `productsearchlog`. `product`

WHERE MONTH(NOW())=MONTH(`productsearchlog`. `timestamp`) AND YEAR(NOW())=YEAR(`productsearchlog`. `timestamp`)
GROUP BY `productsearchlog`.`product`
ORDER BY `count1` DESC
LIMIT 0 , 10")->result();
		return $query;
	}

	function gettoptenproductviewmonth()
	{
		$query=$this->db->query("SELECT COUNT(`productviewlog`.`product`) AS `count1`,`productviewlog`. `id`, `productviewlog`. `product`, `productviewlog`. `user`, `productviewlog`. `timestamp` ,`product`.`name` AS `productname`,YEAR(`productviewlog`. `timestamp`),`productimage`.`image`
FROM `productviewlog`
LEFT OUTER JOIN `product` ON `product`.`id`=`productviewlog`. `product` INNER JOIN `productimage` ON `productimage`.`product`= `productviewlog`. `product`

WHERE YEAR(NOW())=YEAR(`productviewlog`. `timestamp`)
GROUP BY `productviewlog`.`product`
ORDER BY `count1` DESC
LIMIT 0 , 10")->result();
		return $query;
	}
	function gettoptenproductviewyear()
	{
		$query=$this->db->query("SELECT COUNT(`productviewlog`.`product`) AS `count1`,`productviewlog`. `id`, `productviewlog`. `product`, `productviewlog`. `user`, `productviewlog`. `timestamp` ,`product`.`name` AS `productname`,MONTH(`productviewlog`. `timestamp`),`productimage`.`image`
FROM `productviewlog`
LEFT OUTER JOIN `product` ON `product`.`id`=`productviewlog`. `product` INNER JOIN `productimage` ON `productimage`.`product`= `productviewlog`. `product`

WHERE MONTH(NOW())=MONTH(`productviewlog`. `timestamp`) AND  YEAR(NOW())=YEAR(`productviewlog`. `timestamp`)
GROUP BY `productviewlog`.`product`
ORDER BY `count1` DESC
LIMIT 0 , 10")->result();
		return $query;
	}
	function gettoptenbestsellingproductmonth()
	{
		$query=$this->db->query("SELECT count(`orderitems`.`product`) AS `count1`,MONTH(NOW()),`product`.`name`  AS `productname`,`orderitems`.`product` AS `productid`,`order`.`timestamp`,MONTH(`order`.`timestamp`),`productimage`.`image`
FROM `orderitems`
LEFT OUTER JOIN `order` ON `orderitems`.`order`=`order`.`id`
LEFT OUTER JOIN `product` ON `product`.`id`=`orderitems`.`product`
INNER JOIN `productimage` ON `orderitems`. `product`= `productimage`.`product`

WHERE MONTH(NOW())=MONTH(`order`.`timestamp`) AND YEAR(NOW())=YEAR(`order`.`timestamp`)
GROUP BY `orderitems`.`product`
ORDER BY COUNT(`orderitems`.`product`) DESC
LIMIT 0,10")->result();
		return $query;
	}
	function gettoptenbestsellingproductalltime()
	{
		$query=$this->db->query("SELECT count(`orderitems`.`product`) AS `count1`,MONTH(NOW(`order`.`timestamp`)),`product`.`name`  AS `productname`,`orderitems`.`product` AS `productid`,`productimage`.`image`
FROM `orderitems`
LEFT OUTER JOIN `order` ON `orderitems`.`order`=`order`.`id`
LEFT OUTER JOIN `product` ON `product`.`id`=`orderitems`.`product`  INNER JOIN `productimage` ON `productimage`.`product`= `orderitems`. `product`
GROUP BY `orderitems`.`product`
ORDER BY COUNT(`orderitems`.`product`) DESC

LIMIT 0,10")->result();
		return $query;
	}
	function getlastsearchedproductbyuser($userid)
	{
		$query=$this->db->query("SELECT `id`, `product`, `user`, `timestamp` FROM `productviewlog` WHERE `user`='$userid' ORDER BY `timestamp` DESC")->result();
		return $query;
	}
	function gettotalrevenuemonth()
	{
		$query=$this->db->query("SELECT SUM(`orderitems`.`finalprice`) AS `currentmonthrevenue`,MONTH(now()) AS `month`,MONTH(`order`.`timestamp`) AS `timestampmonth`
FROM `orderitems`
LEFT OUTER JOIN `order` ON `order`.`id`=`orderitems`.`order`
WHERE MONTH(NOW())=MONTH(`order`.`timestamp`)
GROUP BY MONTH(now())")->row();
		return $query;
	}
	function gettotalrevenue()
	{
		$query=$this->db->query("SELECT SUM(`orderitems`.`finalprice`) AS `revenue`
FROM `orderitems`
LEFT OUTER JOIN `order` ON `order`.`id`=`orderitems`.`order`")->row();
		return $query;
	}

	function getmonthrevenue()
	{
        $return=array();
        $return[0]=0;
        for($month=1;$month<=12;$month++)
        {
            $query=$this->db->query("SELECT IFNULL(SUM(`orderitems`.`finalprice`),0) AS `currentmonthrevenue`,$month AS `month`,IFNULL(MONTH(`order`.`timestamp`),0) AS `timestampmonth` FROM `orderitems` LEFT OUTER JOIN `order` ON `order`.`id`=`orderitems`.`order` WHERE MONTH(`order`.`timestamp`)=$month AND ( `order`.`timestamp` BETWEEN DATE_SUB(NOW(),INTERVAL 1 YEAR) AND NOW() )")->row();
            $return[$month]=$query->currentmonthrevenue;
        }
		return $return;
	}
    
    function getjustinproducts($category,$color,$price1,$price2)
	{
//        echo $category;
		$getcategoryidbyname=$this->db->query("SELECT * FROM `category` WHERE `id`= '31'")->row();
        $category=$getcategoryidbyname->id;
		$where = "";
		if($price1!="")
		{
		$pricefilter="AND (`product`.`price` BETWEEN $price1 AND $price2 OR `product`.`price`=$price1 OR `product`.`price`=$price2)";
		}
		else
		{
		$pricefilter="";
		}
		$q3 = $this->db->query("SELECT COUNT(*) as `cnt` FROM `category` WHERE `category`.`parent`= '$category'")->row();
		if($q3->cnt > 0)
			$where .= " OR `category`.`parent`='$category' ";
		$query['category']=$this->db->query("SELECT `category`.`name` ,`category`.`image1` FROM `category`
		WHERE `category`.`id`='$category'")->row();

        $querystr="SELECT `justin`.`product`,`justin`.`order`,`product`.`id`,`product`.`name`,`product`.`description`,`product`.`sku`,`product`.`url`,`product`.`price`,`product`.`wholesaleprice`,`product`.`firstsaleprice`,`product`.`secondsaleprice`,`product`.`specialpriceto`,`product`.`specialpricefrom`,`productimage`.`image` 
        FROM `justin`
        LEFT OUTER JOIN `product` ON `product`.`id`=`justin`.`product`
		LEFT OUTER JOIN `productcategory` ON `product`.`id`=`productcategory`.`product`
		LEFT OUTER JOIN `category` ON `category`.`id`=`productcategory`.`category`
		LEFT OUTER JOIN `productimage` ON `productimage`.`product`=`product`.`id`
		WHERE `product`.`visibility`=1 AND `product`.`status`=1 AND `product`.`quantity` > 0 AND `product`.`name` LIKE '%$color%' $pricefilter
		GROUP BY `product`.`id`
		ORDER BY `product`.`id` DESC";
//        echo $querystr;
		$query['product']=$this->db->query($querystr)->result();

		foreach($query['product'] as $p_row)
		{
			$productid = $p_row->id;
			$p_row->productimage=$this->db->query("SELECT `productimage`.`image` FROM `productimage`
			WHERE `productimage`.`product`='$productid'
			ORDER BY `productimage`.`order`
			LIMIT 0,2")->result();
		}
		foreach($query['product'] as $p_row)
		{
			$productid = $p_row->id;
			$query5=$this->db->query("SELECT count(`category`) as `isnew`  FROM `productcategory`
			WHERE  `productcategory`.`category`='31' AND `product`='$productid'
			LIMIT 0,1")->row();
			$p_row->isnew=$query5->isnew;

		}
		/*$query['subcategory']=$this->db->query("SELECT `category`.`name`,`category`.`image1`,`category`.`image2` FROM `category`
		WHERE `category`.`parent`='$category' AND `category`.`status`=1
		ORDER BY `category`.`order`")->result();*/
		$query['subcategory'] = $this->db->query("SELECT `tab1`.`id`,`tab1`.`name`,`tab1`.`image1`,`tab1`.`image2`,COUNT(`tab2`.`id`) as `cnt` FROM
		(
		SELECT `category`.`name`,`category`.`id`,`category`.`image1`,`category`.`image2`,`category`.`order` FROM `category`
			WHERE `category`.`parent`='$category' AND `category`.`status`=1
		) as `tab1`
		INNER JOIN `productcategory` ON `productcategory`.`category`=`tab1`.`id`
		INNER JOIN `product`  as `tab2` ON `productcategory`.`product`=`tab2`.`id` AND `tab2`.`status`=1
		GROUP BY `tab1`.`id`
		ORDER BY `tab1`.`order` ")->result();
		$query['template']=new StdClass();
		$query['breadcrumbs']=$this->getparentcategories($category);
		$query['currentcategory']=$category;
		$query['template']->pageurl = "partials/product.html";
		return $query;
	}
    
    function getsaleproducts($category,$color,$price1,$price2)
	{
//        echo $category;
		$getcategoryidbyname=$this->db->query("SELECT * FROM `category` WHERE `id`= '31'")->row();
        $category=$getcategoryidbyname->id;
		$where = "";
		if($price1!="")
		{
		$pricefilter="AND (`product`.`price` BETWEEN $price1 AND $price2 OR `product`.`price`=$price1 OR `product`.`price`=$price2)";
		}
		else
		{
		$pricefilter="";
		}
		$q3 = $this->db->query("SELECT COUNT(*) as `cnt` FROM `category` WHERE `category`.`parent`= '$category'")->row();
		if($q3->cnt > 0)
			$where .= " OR `category`.`parent`='$category' ";
		$query['category']=$this->db->query("SELECT `category`.`name` ,`category`.`image1` FROM `category`
		WHERE `category`.`id`='$category'")->row();

        $querystr="SELECT `sale`.`product`,`sale`.`order`,`product`.`id`,`product`.`name`,`product`.`description`,`product`.`sku`,`product`.`url`,`product`.`price`,`product`.`wholesaleprice`,`product`.`firstsaleprice`,`product`.`secondsaleprice`,`product`.`specialpriceto`,`product`.`specialpricefrom`,`productimage`.`image` 
        FROM `sale`
        LEFT OUTER JOIN `product` ON `product`.`id`=`sale`.`product`
		LEFT OUTER JOIN `productcategory` ON `product`.`id`=`productcategory`.`product`
		LEFT OUTER JOIN `category` ON `category`.`id`=`productcategory`.`category`
		LEFT OUTER JOIN `productimage` ON `productimage`.`product`=`product`.`id`
		WHERE `product`.`visibility`=1  AND `product`.`name` LIKE '%$color%' $pricefilter
		GROUP BY `product`.`id`
		ORDER BY `product`.`id` DESC";
//        echo $querystr;
		$query['product']=$this->db->query($querystr)->result();

		foreach($query['product'] as $p_row)
		{
			$productid = $p_row->id;
			$p_row->productimage=$this->db->query("SELECT `productimage`.`image` FROM `productimage`
			WHERE `productimage`.`product`='$productid'
			ORDER BY `productimage`.`order`
			LIMIT 0,2")->result();
		}
		foreach($query['product'] as $p_row)
		{
			$productid = $p_row->id;
			$query5=$this->db->query("SELECT count(`category`) as `isnew`  FROM `productcategory`
			WHERE  `productcategory`.`category`='31' AND `product`='$productid'
			LIMIT 0,1")->row();
			$p_row->isnew=$query5->isnew;

		}
		/*$query['subcategory']=$this->db->query("SELECT `category`.`name`,`category`.`image1`,`category`.`image2` FROM `category`
		WHERE `category`.`parent`='$category' AND `category`.`status`=1
		ORDER BY `category`.`order`")->result();*/
		$query['subcategory'] = $this->db->query("SELECT `tab1`.`id`,`tab1`.`name`,`tab1`.`image1`,`tab1`.`image2`,COUNT(`tab2`.`id`) as `cnt` FROM
		(
		SELECT `category`.`name`,`category`.`id`,`category`.`image1`,`category`.`image2`,`category`.`order` FROM `category`
			WHERE `category`.`parent`='$category' AND `category`.`status`=1
		) as `tab1`
		INNER JOIN `productcategory` ON `productcategory`.`category`=`tab1`.`id`
		INNER JOIN `product`  as `tab2` ON `productcategory`.`product`=`tab2`.`id` AND `tab2`.`status`=1
		GROUP BY `tab1`.`id`
		ORDER BY `tab1`.`order` ")->result();
		$query['template']=new StdClass();
		$query['breadcrumbs']=$this->getparentcategories($category);
		$query['currentcategory']=$category;
		$query['template']->pageurl = "partials/product.html";
		return $query;
	}
}
?>
