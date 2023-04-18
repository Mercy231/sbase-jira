<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public array $result = array();
    public function index ()
    {
        return view('autoria')->with(['data' => $this->scraper()]);
    }
    public function search (Request $request)
    {
        $url = 'https://auto.ria.com/uk/search/?indexName=auto,order_auto,newauto_search';
        if ($request->type) {
            $url .= '&categories.main.id=' . $request->type;
        }
        if ($request->brand) {
            $url .= '&brand.id[0]=' . $request->brand;
        }
        if ($request->yearFrom && $request->yearFrom != 0) {
            $url .= '&year[0].gte=' . $request->yearFrom;
        }
        if ($request->yearTo && $request->yearTo != 0) {
            $url .= '&year[0].lte=' . $request->yearTo;
        }
        if ($request->priceFrom) {
            $url .= '&price.USD.gte=' . $request->priceFrom;
        }
        if ($request->priceTo) {
            $url .= '&price.USD.lte=' . $request->priceTo;
        }
        $html = view('components.cars')->with(['data' => $this->scraper($url)])->render();
        return response()->json(['success' => true, 'html' => $html, 'url' => $url, 'data' => $this->scraper($url)]);
    }
    public function scraper ($url = 'https://auto.ria.com/uk/legkovie/')
    {
        $client = new Client();
        $page = $client->request('GET', $url);
        $page->filter('div.content-bar')->each(function ($item) {
            $data = array();

            $data['name'] = $item->filter('a.address')->text();
            $data['link'] = trim($item->filter('a.m-link-ticket')->attr('href'));
            $data['image'] = trim($item->filter('div.ticket-photo > a > picture > source')->attr('srcset'));
            $data['priceUSD'] = trim($item->filter('div.price-ticket > span > span')->text());
            $data['priceUAH'] = trim($item->filter('div.price-ticket > span > span')->eq(3)->filter('span > span')->text());
            $data['mileage'] = trim($item->filter('div.definition-data > ul > li')->eq(0)->text());
            $data['location'] = trim($item->filter('div.definition-data > ul > li')->eq(1)->text());
            $data['fuelType'] = trim($item->filter('div.definition-data > ul > li')->eq(2)->text());
            $data['transmissionType'] = trim($item->filter('div.definition-data > ul > li')->eq(3)->text());
            $data['color'] = $this->colorScraper($data['link']);
            $this->result[] = $data;
        });
        return $this->result;
    }
    public function colorScraper ($url) {
        $client = new Client();
        $page = $client->request('GET', $url);
        return trim($page->filterXPath('//*[@id="details"]/dl[1]/dd[contains(.//span, "Колір")]/span[2]')->text());
    }
}
