<?php 
use Slim\Http\Request; //namespace 
use Slim\Http\Response; //namespace 

//include productsProc.php file
include __DIR__ . '/../function/productsProc.php';

//read table products (Get Method)
$app->get('/products', function (Request $request, Response $response, array $arg){
     return $this->response->withJson(array('data' =>'success'), 200); 
    });

//request table products by condition
$app->get('/products/[{price}]', function ($request, $response, $args){ 
     
     $productPrice = $args['price'];
      if (!is_numeric($productPrice)) { 
           return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
     }
$data = getProduct($this->db,$productPrice);
     if (empty($data)) { 
          return $this->response->withJson(array('error' => 'no data'), 404); 
          } 
          return $this->response->withJson(array('data' => $data), 200);
     });


//delete row
$app->delete('/products/del/[{price}]', function ($request, $response, $args){

     $productPrice = $args['price'];
    if (!is_numeric($productPrice)) {
       return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
    }
   $data = deleteProduct($this->db,$productPrice);
   if (empty($data)) {
    return $this->response->withJson(array($productPrice=> 'is successfully deleted'), 202);};
   });


//put table products
$app->put('/products/put/[{price}]', function ($request, $response, $args){
     $productPrice = $args['price'];
     $date = date("Y-m-j h:i:s");

if (!is_numeric($productPrice)) {
          return $this->response->withJson(array('error' => 'numeric paremeter required'), 422);
     }
     
     $form_dat=$request->getParsedBody();
     
     $data=updateProduct($this->db,$form_dat,$productPrice,$date);
     if ($data <=0)
     return $this->response->withJson(array('data' => 'successfully updated'), 200);
});