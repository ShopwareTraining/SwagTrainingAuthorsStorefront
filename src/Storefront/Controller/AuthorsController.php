<?php declare(strict_types=1);

namespace SwagTraining\AuthorsStorefront\Storefront\Controller;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\ContainsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Routing\Annotation\Since;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"storefront"})
 */
class AuthorsController extends StorefrontController
{
    private EntityRepositoryInterface $productRepository;

    public function __construct(EntityRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Since("6.4.0.0")
     * @Route("/authors", name="frontend.swag-training.authors", methods={"GET"},
     *                    defaults={"XmlHttpRequest"=true})
     */
    public function getData(Request $request, Context $context): Response
    {
        $criteria = new Criteria;
        $criteria->addFilter(new EqualsFilter('parentId', null));
        $criteria->addFilter(new ContainsFilter('name', 'M'));
        $criteria->setLimit(3);

        $products = $this->productRepository->search($criteria, $context);

        return $this->renderStorefront(
            '@SwagTrainingAuthorsStorefront/storefront/page/content/authors.html.twig', [
            'products' => $products,
        ]);
    }
}
