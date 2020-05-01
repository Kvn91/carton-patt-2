<?php

namespace App\Controller;

use App\Document\Restaurant;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route as Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RestaurantController
 *
 * @author Kev
 */
class RestaurantController extends AbstractController
{
	/**
	 * @Route("/api/restaurant/create", name="api_restaurant_create", methods={"POST"})
	 * @param DocumentManager $manager
	 * @param Request $request
	 * @param SerializerInterface $serializer
	 * @param ValidatorInterface $validator
	 * @return JsonResponse
	 */
	public function create(
		DocumentManager $manager,
		Request $request,
		SerializerInterface $serializer,
		ValidatorInterface $validator
	) {
		$json = $request->getContent();

		try {
			$restaurant = $serializer->deserialize($json, Restaurant::class, 'json');

			$errors = $validator->validate($restaurant);
			if (count($errors) > 0) {
				return $this->json($errors, 400);
			}

			$manager->persist($restaurant);
			$manager->flush();

			return $this->json($restaurant, 201, [], ['groups' => 'restaurant:read']);
		} catch (NotEncodableValueException $exception) {
			return $this->json([
				'status' => 400,
				'message' => $exception->getMessage()
			], 400 );
		}
	}

	/**
	 * @Route("/api/restaurant/get/{id}", name="api_restaurant_get", methods={"GET"})
	 * @param DocumentManager $manager
	 * @param $id
	 * @return JsonResponse
	 */
	public function find(DocumentManager $manager, $id)
	{
		$restaurantRepo = $manager->getRepository(Restaurant::class);
		$restaurant = $restaurantRepo->find($id);

		if (null === $restaurant) {
			return $this->json([
				'status' => 400,
				'message' => sprintf('Le restaurant ayant pour id %s est introuvable', $id)
			], 400);
		}

		return $this->json($restaurant, 200, [], ['groups' => 'restaurant:read']);
	}

	/**
	 * @Route("/api/restaurant/get-all", name="api_restaurant_get_all", methods={"GET"})
	 * @param DocumentManager $manager
	 * @return JsonResponse
	 */
	public function findAll(DocumentManager $manager)
	{
		$restaurantRepo = $manager->getRepository(Restaurant::class);
		$restaurants = $restaurantRepo->findAll();

		return $this->json($restaurants, 201, [], ['groups' => 'restaurant:read']);
	}
}
