<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeScreenController extends AbstractController
{
    /**
     * @Route("/home/", name="home_screen", methods={"POST", "DELETE", "GET"})
     */

    public function index(Request $request):Response {
//        $resp = new Response('<h1>Hello there!</h1>');
//        return $resp;
//        return $this->json(['message'=>'Hi! this is a json response']);
        return $this->json(['message'=> $request->query->get('page'),
            'path'=>'src/Controller/HomeScreenController.php',
            ]);
    }

    /**
     * @Route("/recipes/all", name="get_all_recipes", methods={"GET"})
     */
        public function getAllRecipes() {
            $rootPath = $this->getParameter('kernel.project_dir');
            $recipes = file_get_contents($rootPath.'/resources/recipes.json');
            $decodedRecipes = json_decode($recipes, true);

            return $this->json($decodedRecipes);

    }
    /**
     * @Route("/recipe/{id}", name="get_a_recipe", methods={"GET"})
     */
    public function recipe($id, Request $request) {
        return $this->json([
            'message'=>'Requesting recipe with id' . $id,
            'page'=>   $request->query->get('page')
        ]);
    }

    /**
     * @Route("/other")
     */
    public function other() {
        return $this->redirect('home');
    }
}
