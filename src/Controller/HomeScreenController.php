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
     * @Route("/recipe/add", name="add_new_recipe", methods={"POST"})
     */
    public function addRecipe(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $data=json_decode($request->getContent(), true);
        $newRecipe = new Recipe();
        $newRecipe->setName($data["name"]);
        //$newRecipe->setIngredients($data["ingredients"]);
        $newRecipe->setIngredients(["test1", "ingr2", "ingredient3"]);
        $newRecipe->setImage($data["image"]);
        $newRecipe->setPrepTime($data["prepTime"]);
        $newRecipe->setServings($data["servings"]);
        $newRecipe->setInstructions($data["instructions"]);

        $entityManager->persist($newRecipe);

        $entityManager->flush();

        return new Response('Trying to add new recipe...' . $newRecipe->getId());
    }

    /**
     * @Route("/recipe/all", name="get_all_recipe", methods={"GET"})
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
                'image' => $recipe->getImage(),
                'prepTime' => $recipe->getPrepTime(),
                'servings' => $recipe->getServings(),
                'instructions' => $recipe->getInstructions()
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
                'image' => $recipe->getImage(),
                'prepTime' => $recipe->getPrepTime(),
                'servings' => $recipe->getServings(),
                'instructions' => $recipe->getInstructions()
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
