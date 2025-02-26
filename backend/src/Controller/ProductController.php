<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ProductService;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProductController extends CustomAbstractController
{
    public function __construct(private ProductService $productService, protected SerializerInterface $serializer, private EntityManagerInterface $entityManager)
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
    // #[IsGranted('ROLE_ADMIN')]
    public function createProduct(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $product = new Product();
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPrice($data['price']);
        $product->setImageUrl($data['image_url']);
        $product->setStockQuantity($data['stock_quantity']);
        $product->setCreatedAt(new DateTime());
        $product->setUpdatedAt(new DateTime());
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return $this->formatResult( $product, ['product']);
    }



    #[Route('api/products/{id}', methods: ['PUT'])]
    // #[IsGranted('ROLE_ADMIN')]
    public function updateProduct(int $id, Request $request): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);
        if(!$product){
            return new JsonResponse(['message'=> 'Product does not exist'], 404);
        }

        $data = json_decode($request->getContent(), true);
       
        if (isset($data['name'])) {
            $product->setName((string) $data['name']);
        };
        if(isset($data['description'])){
            $product->setDescription((string) $data['description']);  
        }
        if(isset($data['price'])){
            $product->setPrice((float) $data['price']);
        }
        if(isset($data['image_url'])){
            $product->setImageUrl((string) $data['image_url']);
        }
        if(isset($data['stock_quantity'])){
            $product->setStockQuantity((int) $data['stock_quantity']);
        }

        $product->setUpdatedAt(new DateTime());
        $this->entityManager->flush();
 
        return $this->formatResult( $product, ['product']);
      
    }

    #[Route('api/products/{id}', methods: ['DELETE'])]
    // #[IsGranted('ROLE_ADMIN')]
    public function deleteProduct(int $id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);
        if(!$product){
            return new JsonResponse(['message'=> 'Product does not exist'], 404);
        }
        $this->entityManager->remove($product);
        $this->entityManager->flush();
        return new JsonResponse(['message'=> 'Product sucessfully deleted'], 200);  
    }
}