<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use function dd;

/**
 * Description of VoyagesControllerTest
 *
 * @author Doryan
 */
class VoyagesControllerTest extends WebTestCase{
    public function testAccesPage(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        $this ->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    public function testContenuPage(){
        $client = static::createClient();
        $crawler= $client->request('GET', '/voyages');
        $this->assertSelectorTextContains('h1', 'Mes Voyages');
        $this->assertSelectorTextContains('th', 'Ville');
        $this->assertCount(4, $crawler ->filter('th'));
        $this->assertSelectorTextContains('h5', 'Blondelboeuf');
    }
    public function testLinkVille(){
        $client = static::createClient();
        $client->request('GET','/voyages');
        //clic sur un lien (le nom d'une ville)
        $client->clickLink('Blondelboeuf');
        //recuperation du resultat du clic
        $response = $client->getResponse();
        
        //controle si le lien existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        // recuperation de la route et controle qu'elle est correcte
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/voyages/voyage/3', $uri);
    }
    public function testFiltreVille(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        //simulation de la soumission du formulaire
        $crawler = $client->submitForm('filtrer', [
            'recherche' => 'Blondelboeuf'
        ]);
        //verifie le nombre de lignes obtenues
        $this->assertCount(1, $crawler->filter('h5'));
        //verifie si la ville correspond a la recherche
        $this->assertSelectorTextContains('h5', 'Blondelboeuf');
    }
}
 