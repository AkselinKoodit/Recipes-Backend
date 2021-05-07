<?php


namespace App\Controller;

use App\Entity\Recipe; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeScreenController extends AbstractController
{

    /**
     * @Route("/recipe/add", name="add_new_recipe")
     */
    public function addRecipe()
    {

        $entityManager = $this->getDoctrine()->getManager();

        $newRecipe = new Recipe();
        $newRecipe->setName('Omelette');
        $newRecipe->setIngredients('eggs, oil, milk');
        $newRecipe->setDifficulty('easy');

        $newRecipe1 = new Recipe();
        $newRecipe1->setName('banana pancakes');
        $newRecipe1->setIngredients('banana, eggs, oil');
        $newRecipe1->setDifficulty('easy');

        $entityManager->persist($newRecipe);
        $entityManager->persist($newRecipe1);

        $entityManager->flush();

        return new Response('Trying to add new recipe...' . $newRecipe->getId() . " and " . $newRecipe1->getId());
    }

    /**
     * @Route("/recipe/all", name="get_all_recipe")
     */
    public function getAllRecipe()
    {
        $recipes = $this->getDoctrine()->getRepository(Recipe::class)->findAll();

        $response = [];

        foreach ($recipes as $recipe) {
            $response[] = array(
                'id' => $recipe->getId(),
                'name' => $recipe->getName(),
                'ingredients' => $recipe->getIngredients(),
                'difficulty' => $recipe->getDifficulty()
            );
        }
        return $this->json($response);
    }

    /**
     * @Route("/recipe/find/{id}", name="find_a_recipe")
     */
    public function findRecipe($id)
    {
        $recipe = $this->getDoctrine()->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException(
                'No recipe found with this id' . $id
            );
        } else {
            return $this->json([
                'id' => $recipe->getId(),
                'name' => $recipe->getName(),
                'ingredients' => $recipe->getIngredients(),
                'difficulty' => $recipe->getDifficulty()
            ]);
        }
    }

    /**
     * @Route("/recipe/edit/{id}/{name}", name="edit_a_recipe")
     */
    public function editRecipe($id, $name)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $recipe = $this->getDoctrine()->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException(
                'No recipe found with this id' . $id
            );
        } else {
            $recipe->setName($name);
            $entityManager->flush();

            return $this->json([
                'message' => 'Edited a recipe with id' . $id
            ]);
        }

    }
    /**
     * @Route("/recipe/remove/{id}", name="remove_a_recipe")
     */
    public function removeRecipe($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $recipe = $this->getDoctrine()->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException(
                'No recipe found with this id' . $id
            );
        } else {
            $entityManager->remove($recipe);
            $entityManager->flush();

            return $this->json([
                'message' => 'Removed recipe with id ' . $id
            ]);
        }

    }
}
