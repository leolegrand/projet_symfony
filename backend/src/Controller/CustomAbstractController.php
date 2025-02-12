<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Service\ProductService;

class CustomAbstractController extends AbstractController
{

    public function __construct(protected SerializerInterface $serializer)
    {
     
    }

    public function formatResult($data = null, array $groups = null, int $statusCode = null): Response {
        return new Response($this->serializer->serialize($data, JsonEncoder::FORMAT, [
            'groups' => $groups,
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
        ]), $statusCode ?? 200);
    }


}
