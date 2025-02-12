<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ProductService;

class ProductController extends AbstractController
{
    private $productService;

    public function __construct(ProductService $ProductServices)
    {
        $this->productService = $ProductServices;
    }

    #[Route('/products', name: 'app_products', methods: ['GET'])]
    public function index(): Response
    {
        $products = $this->productService->getAllProducts();

        return $this->render('product/list.html.twig', [
            'products' => $products,
        ]);
    }
}
