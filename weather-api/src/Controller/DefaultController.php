<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpClient\HttpClient;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index(Request $request): Response
    {
        $ip = $this->getIpAdress();
        $location = $this->getLocation($ip);
        // $location = 'Riga';
        echo $this->getForecast($location);
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }


    public function getIpAdress()
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://api.ipify.org/');
        $content = $response->getContent();
        return $content;
    }

    public function getLocation($ip)
    {
        $access_key = 'ff0dc6aefeed23e9ed7517f34831efab';

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'http://api.ipstack.com/' . $ip . '?access_key=' . $access_key);
        $content = $response->getContent();

        $content = json_decode($content, true);

        return $content['location']['capital'];
    }

    public function getForecast($location)
    {

        $url='http://api.openweathermap.org/data/2.5/weather?q=' . $location . '&appid=683bedea74899f8feddded8c233bcda2';
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $url);
        $content = $response->getContent();
        return $content;
    }    





}
