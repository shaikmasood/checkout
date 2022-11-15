<?php 
include './config/Database.php'; 
use Database\Database as db;

Class Crud{

	private $db;

	public function __construct($database){
		$this->db = $database->connect();
	}

	public function getRecord(){
		/*$query = 'SELECT c.name as category_name, p.category_id, p.id, p.title, p.body, p.author, p.created_at
                FROM posts p
                LEFT JOIN
                  categories c ON p.category_id = c.id
                ORDER BY
                  p.created_at DESC';*/
    /*$query = 'SELECT p.item, p.unit_price,p.image, p.id, so.product_id, so.unit, so.price, so.linked_product_price, so.offer_status
                FROM products p
                LEFT JOIN
                  special_offers so ON p.id = so.product_id
                ';*/
    $response = array();
    $query = 'SELECT p.item, p.unit_price,p.image, p.id FROM products p';
		$resultset = mysqli_query($this->db, $query) 
		or die("database error:". mysqli_error($this->db));
				
		while($rows = mysqli_fetch_assoc($resultset)) 
		{
			extract($rows);
			$post_item = array(
				'product_id' => $id,
				'title' => $item,
				//'body' => html_entity_decode($body),
				'unit_price' => $unit_price,
				'image' => $image
			);
			$response['products'][] = $post_item;
		}

		$queryOffer = "select so.product_id, so.unit, so.price, so.linked_product_price, so.offer_status from special_offers as so where so.offer_status = '1'";
		$resultset_offer = mysqli_query($this->db, $queryOffer) 
		or die("database error:". mysqli_error($this->db));
				
		while($rows_offer = mysqli_fetch_assoc($resultset_offer)) 
		{
			extract($rows_offer);
			$post_item_offer[$product_id][] = array(
				'product_id' => $product_id,
				'so_unit' => $unit,
				'so_price' => $price,
				'so_linked_product_price' => $linked_product_price
			);
			$response['special_offers'] = $post_item_offer;
		}

		return $response;
	}
}

$crubObj = new Crud(new db);

?>