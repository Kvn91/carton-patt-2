<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Document\Restaurant;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * Class RestaurantPersister
 *
 * @author Kev
 */
class RestaurantPersister implements DataPersisterInterface
{
	/**
	 * @var DocumentManager
	 */
	private $documentManager;

	/**
	 * @param DocumentManager $documentManager
	 */
	public function __construct(DocumentManager $documentManager)
	{
		$this->documentManager = $documentManager;
	}

	public function supports($data): bool
	{
		return ($data instanceof Restaurant);
	}

	/**
	 * @inheritdoc
	 */
	public function persist($data)
	{
		$this->documentManager->persist($data);
		$this->documentManager->flush();
	}

	/**
	 * @inheritdoc
	 */
	public function remove($data)
	{
		$this->documentManager->remove($data);
		$this->documentManager->flush();
	}
}