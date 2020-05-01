<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Document\Restaurant;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * Class RestaurantController
 *
 * @author Kev
 */
class RestaurantController extends AbstractController
{
	/**
	 * @Route("/api/create", name="api_create_restaurant", methods={"POST"})
	 * @param DocumentManager $manager
	 * @param Request $request
	 * @param SerializerInterface $serializer
	 * @param ValidatorInterface $validator
	 * @return mixed
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

			dd($restaurant);
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
	 * @Route("/api/find/{id}", name="api_find_restaurant", methods={"GET"})
	 */
	public function find(Restaurant $restaurant)
	{
		return $this->json($restaurant, 200, [], ['groups' => 'restaurant:read']);
	}

}
