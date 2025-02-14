<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ProductService;
use DateTime;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends CustomAbstractController
{
    public function __construct(private ProductService $productService, SerializerInterface $serializer)
    {
        parent::__construct($serializer);
    }

    #[Route('api/products', methods: ['GET'])]
    public function getProducts(): Response
    {
        $products = $this->productService->getAllProducts();
        return $this->formatResult($products, ['product']);

       
    }

    #[Route('api/products/{id}', methods: ['GET'])]
    public function getProductId(int $id): Response
    {
        $product = $this->productService->getProductById(id: $id);
        return $this->formatResult($product, ['product']);

       
    }

    #[Route('api/products', methods: ['POST'])]
    public function createProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $product = new Product();
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPrice($data->price);
        $product->setImageUrl($data['image_url']);
        $product->setStockQuantity($data['stock_quantity']);
        $product->setCreatedAt(new DateTime());
        $product->setUpdatedAt(new DateTime());
        $entityManager->persist($product);
        $entityManager->flush();



    
      

        // return $this->json($data, Response::HTTP_OK);
        // $product = new Product();

        // return $this->json($product, response::HTTP_CREATED, [],['Groups'=>['product']]);
        

        return $this->formatResult( $product, ['product']);

       
    }
}
