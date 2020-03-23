<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private $products;

    public function __construct()
    {
        $this->products = [
            ["nom" => "iPhone X","slug" => "iphone-x","description" => "Un iPhone de 2017","prix" => 999],
            ["nom" => "iPhone XR","slug" => "iphone-xr","description" => "Un iPhone de 2018","prix" => 1099],
            ["nom" => "iPhone XS","slug" => "iphone-xs","description" => "Un iPhone de 2019","prix" => 1199]
        ];
    }

    /**
     * @Route("/product", name="liste_product")
     */
    public function liste()
    {
        return $this->render('product/index.html.twig', [
            'products' => $this->products
        ]);
    }

    /**
     * @Route("/product/random", name="product_aleatoire")
     */
    public function produitAlea()
    {
        $rand = random_int(0,count($this->products)-1);

        return $this->render('product/random.html.twig', [
            'product' => $this->products[$rand]
        ]);
    }

     /**
     * @Route("/product/create", name="creer_product")
     */
    public function creer()
    {

        return $this->render('product/create.html.twig', [
        ]);
    }

    /**
     * @Route("/product.json", name="json_product")
     */
    public function getProductJson(Request $request)
    {
        if ($request->isXmlHttpRequest())
        return $this->json($this->products);
        else
        return;
    }

    /**
     * @Route("/product/{slug}", name="voir_product")
     */
    public function voir($slug)
    {
        $product = null;
        for ($i=0; $i < count($this->products); $i++) { 
            if ($this->products[$i]["slug"] == $slug){
            $product = $this->products[$i];
            break;
        }
        }
        if ($product){
        return $this->render('product/voir.html.twig', [
            'product' => $product
        ]);
        }
        else
        throw $this->createNotFoundException("Ce produit n'existe pas");
    }

}
