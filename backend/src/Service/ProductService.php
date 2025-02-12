<?php

namespace App\Service;
use App\Entity\Product;
use App\Repository\ProductRepository;

    class ProductService{

        public function __construct(private ProductRepository $productRepository)
        {

        }

        /**
         * Summary of getProducts
         * @return Product[]
         */
    
        public function getAllProducts(): array {
            return $this->productRepository->findAll();
        }
    }