<?php


namespace BigCommerce\ApiV3\Catalog;


use BigCommerce\ApiV3\Api\ResourceApi;
use BigCommerce\ApiV3\Catalog\Brands\BrandImageApi;
use BigCommerce\ApiV3\ResponseModels\BrandResponse;
use BigCommerce\ApiV3\ResponseModels\BrandsResponse;

class BrandsApi extends ResourceApi
{
    private const RESOURCE_NAME   = 'brands';
    private const BRAND_ENDPOINT  = 'catalog/brands/%d';
    private const BRANDS_ENDPOINT = 'catalog/brands';

    protected function singleResourceEndpoint(): string
    {
        return self::BRAND_ENDPOINT;
    }

    protected function multipleResourcesEndpoint(): string
    {
        return self::BRANDS_ENDPOINT;
    }

    protected function resourceName(): string
    {
        return self::RESOURCE_NAME;
    }

    public function get(): BrandResponse
    {
        return new BrandResponse($this->getResource());
    }

    public function getAll(array $filters = [], int $page = 1, int $limit = 250): BrandsResponse
    {
        return new BrandsResponse($this->getAllResources($filters, $page, $limit));
    }

    public function getAllPages(array $filter = []): BrandsResponse
    {
        return BrandsResponse::BuildFromAllPages(function($page) use ($filter) {
            return $this->getAllResources($filter, $page, 200);
        });
    }

    public function image(): BrandImageApi
    {
        return new BrandImageApi($this->getClient(), null, $this->getResourceId());
    }
}