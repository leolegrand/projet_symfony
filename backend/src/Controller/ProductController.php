<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ProductService;

class ProductController extends CustomAbstractController
{
    public function __construct(private ProductService $productService, SerializerInterface $serializer)
    {
        parent::__construct($serializer);

    }

    #[Route('/products', name: 'app_products', methods: ['GET'])]
    public function index(): Response
    {
        $products = $this->productService->getAllProducts();
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'controller_name' => "Produit"
        ]);
       
    }

    #[Route('/productsJson', name: 'app_products_json', methods: ['GET'])]
    public function indexJson(): Response
    {
        $products = $this->productService->getAllProducts();
        return $this->formatResult($products, ['product']);

       
    }
}
