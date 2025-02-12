<?php

namespace App\Service;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;

    class ProductService{
        private EntityManagerInterface $entityManager;
        private ProductRepository $productRepository;
    
        public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository)
        {
            $this->entityManager = $entityManager;
            $this->productRepository = $productRepository;
        }

        /**
         * Summary of getProducts
         * @return Product[]
         */
    
        public function getAllProducts(): array {
            return $this->productRepository->getAllProducts();
        }
    }