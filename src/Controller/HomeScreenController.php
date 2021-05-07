<?php


namespace App\Controller;

use App\Entity\Recipe; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeScreenController extends AbstractController
{

//     Update /recipe/add route so that it adds new recipe according to request parameters such as
// /recipe/add?name=pancake&ingredients=flour,egg,milk&difficulty=medium

    /**
     * @Route("/recipe/add", name="add_new_recipe")
     */
    public function addRecipe(){

        $entityManager = $this->getDoctrine()->getManager();

        $newRecipe = new Recipe();
        $newRecipe ->setName('Omelette');
        $newRecipe ->setIngredients('eggs, oil, milk');
        $newRecipe ->setDifficulty('easy');

        $newRecipe1 = new Recipe();
        $newRecipe1 ->setName('banana pancakes');
        $newRecipe1 ->setIngredients('banana, eggs, oil');
        $newRecipe1 ->setDifficulty('easy');

        $entityManager->persist($newRecipe);
        $entityManager->persist($newRecipe1);

        $entityManager->flush();

        return new Response('trying to add new recipe...' . $newRecipe->getId() . " and " . $newRecipe1->getId());
    }

    
    /**
     * @Route("/recipe/more?name={name}&ingredients={ingredients}&difficulty={difficulty}", name="put_a_recipe", methods={"GET"})
     */

    public function recipe($name, $ingredients, $difficulty) {
        
        echo $name;
        return $difficulty;
    }
        // $newRecipe2 = new Recipe();
        // $newRecipe2->setName($name);
        // $newRecipe2->setIngredients($ingredients);
        // $newRecipe2->setDifficulty($difficulty);

        // $entityManager->persist($newRecipe2);

        // $entityManager->flush();


        // return $this->json([
        //     'message'=>'Adding a new recipe' . $name,
        //     'page'=>   $request->query->get('name')
        // ]);

        // $this->json([
        //     $this.recipe.name=>$request->query->get('name'),
        //     $this.recipe.ingredients=>$request->query->get('ingredients'),
        //     $this.recipe.difficulty=>$request->query->get('difficulty')
            
        //     return new Response('trying to add new recipe according to params...' . $newRecipe2->getId());
        // ]);


    /**
     * @Route("/recipe/all", name="get_all_recipe")
     */
    public function getAllRecipe(){
        $recipes = $this->getDoctrine()->getRepository(Recipe::class)->findAll();

        $response=[];

        foreach($recipes as $recipe) {
            $response[]=array(
                'id' => $recipe->getId(),
                'name'=>$recipe->getName(),
                'ingredients'=>$recipe->getIngredients(),
                'difficulty'=>$recipe->getDifficulty()
            );
        }
        return $this->json($response);
    }

}
