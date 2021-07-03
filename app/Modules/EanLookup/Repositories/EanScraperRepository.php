<?php

namespace App\Modules\EanLookup\Repositories;

use App\Modules\EanLookup\Interfaces\EanLookupInterface;
use App\Modules\EanLookup\Entities\EanProduct;
use Goutte\Client;

class EanScraperRepository implements EanLookupInterface
{
    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param int $ean
     * @return EanProduct
     */
    public function find(int $ean): EanProduct
    {
        $crawler = $this->client->request('GET', 'https://google.com/search?tbm=shop&q=' . $ean);

        $form = $crawler->selectButton('I agree');

        if ($form->count()) {
            $crawler = $this->client->submit($form->form());
        }

        $container = $crawler->filter('body > div')->reduce(fn($carry, $div) => $div);
        $link = $container->filter('a')->eq(9)->text();

        preg_match('/(.*)\s(\[|\()*(Blu-ray|DVD).*/', $link, $components);

        return new EanProduct(
            $components[1] ?? $link,
            $ean
        );
    }
}
