<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use League\OAuth2\Client\Provider\Google;
use Google\Client as Google_Client;
use Google\Service\Drive\Drive ;
class GoogleController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/google", name="connect_google_start")
     * @param ClientRegistry $clientRegistry
     * @return Symfony\Component\HttpFoundation\RedirectResponse

     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('google') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect(['public_profile','email']);
    }

    /**
     * After going to google, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @Route("/connect/google/check", name="connect_google_check")
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse

     */
    public function connectCheckAction(Request $request , ClientRegistry $clientRegistry)
    { 
        
    $code = $_GET['code'];
        
    header('Content-Type: text/html');
   $client = $clientRegistry->getClient('google');
   
    dd($client);
    
    $user = $client->fetchUser();
  

    try {
        // the exact class depends on which provider you're using
        /** @var \League\OAuth2\Client\Provider\FacebookUser $user */
        $user = $client->fetchUser();

        // do something with all this new power!
        // e.g. $name = $user->getFirstName();
        dd($user); 
    } catch (IdentityProviderException $e) {
        // something went wrong!
        // probably you should return the reason to the user
        dd('error'.$e->getMessage());
    }


    }
}