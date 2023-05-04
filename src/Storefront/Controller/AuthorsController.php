<?php declare(strict_types=1);

namespace SwagTraining\AuthorsStorefront\Storefront\Controller;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Routing\Annotation\Since;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"storefront"})
 */
class AuthorsController extends StorefrontController
{
    private EntityRepositoryInterface $authorRepository;

    /**
     * AuthorsController constructor.
     * @param EntityRepositoryInterface $authorRepository
     */
    public function __construct(
        EntityRepositoryInterface $authorRepository
    )
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @Since("6.4.0.0")
     * @Route("/swag-training/authors", name="frontend.swag-training.authors", methods={"GET"}, defaults={"XmlHttpRequest"=true})
     */
    public function getData(Request $request, Context $context): Response
    {
        $criteria = new Criteria;
        $criteria->setLimit(3);

        $authors = $this->authorRepository->search($criteria, $context);

        return $this->renderStorefront(
            '@SwagTrainingAuthorsStorefront/storefront/page/content/authors.html.twig', [
            'authors' => $authors,
        ]);
    }
}
