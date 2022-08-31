<?php

namespace App\Controller;

use App\ChatBot\Conversation\OnBoardingConversation;
use App\ChatBot\Conversation\QuestionConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Web\WebDriver;
use ReceiveMiddleware;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/SdiBot')]
class ChatController extends AbstractController
{
    
    #[Route('/', name: 'SdiBot')]
    public function index(): Response
    {
        return $this->render('chat/index.html.twig');
    }
    #[Route('/message', name: 'BotMessage')]
    public function message(SymfonyCache $symfonyCache): Response
    {
        DriverManager::loadDriver(WebDriver::class);
        $botman = BotManFactory::create([], $symfonyCache);

        $botman->middleware->received(new ReceiveMiddleware());
        
        $botman->hears(
            'hello{salut}',
            function (BotMan $bot) {
                $bot->reply('Hello,Je suis Votre Assistant SDI');
            }
        );

        $botman->hears('My First Message', function ($bot) {
            $bot->reply('Your First Response');
        });

        $botman->hears(
            'How are {you}',
            function (BotMan $bot) {
                $bot->reply('Fine And you');
            }
        );

        $botman->hears('Call me {name}', function(BotMan $bot, $name) {
            $bot->typesAndWaits(2);
        
            $bot->reply('Hi '.$name);
            $bot->reply('Nice to meet you 😊');
        });

        $botman->hears('Aide {name}', function(BotMan $bot, $name) {
            $bot->typesAndWaits(2);
            $bot->reply('Dis Moi Concretement ce que tu veux');
        });

        $botman->hears('Je {name}', function(BotMan $bot, $name) {
            $bot->typesAndWaits(2);
            $bot->reply('Je te deteste aussi,Chien La 😊');
        });

        $botman->hears('comment faire une demande  {name}', function(BotMan $bot, $name) {
            $bot->typesAndWaits(2);
            $bot->reply('Créez un Compte,Connectez-vous et rendez-vou sur votre Dashboard');
        });

        $botman->hears('Creer Moi un {name}', function(BotMan $bot, $name) {
            $bot->typesAndWaits(2);
            $bot->reply('Quel genre de Compte Desirez-Vous Creer');
            $bot->typesAndWaits(2);
            $bot->reply('Client/Personnel/Technicien?');
        });

        $botman->hears('{Client}', function(BotMan $bot, $name) {
            $bot->typesAndWaits(2);
            $bot->reply("D'accord");
        });

        $botman->hears(
            'weather in {location}',
            function (BotMan $bot, string $location) {
                $response = $this->fetchWeatherData($location);
                $bot->reply(sprintf('<img src="%s" alt="icon"/>', $response->current->weather_icons[0]));
                $bot->reply(sprintf('Weather in %s is %s!', $response->location->name, $response->current->weather_descriptions[0]));
            }
        );

       
        $botman->hears(
            '/gif {name}',
            function (BotMan $bot, string $name) {
                $bot->reply(
                    OutgoingMessage::create('this is your gif')
                        ->withAttachment($this->fetchGiphyGif($name))
                );
            }
        );

       
        $botman->hears(
            'my name is {name}',
            function (BotMan $bot, string $name) {
                $bot->userStorage()->save(['name' => $name]);
                $bot->reply('Hello, ' . $name);
            }
        );

        $botman->hears(
            'say my name',
            function (BotMan $bot) {
                $bot->reply('Your name is ' . $bot->userStorage()->get('name'));
            }
        );

    
        $botman->hears(
            'information',
            function (BotMan $bot) {
                $user = $bot->getUser();
                $bot->reply('First name: ' . $user->getFirstName());
            }
        );

    
        $botman->hears(
            'survey',
            function (BotMan $bot) {
                $bot->reply('I am going to start the on-boarding conversation');
                $bot->startConversation(new OnBoardingConversation());
            }
        );

        $botman->hears(
            'help',
            function (BotMan $bot) {
                $bot->reply('This is the help information.');
            }
        )->skipsConversation();

        $botman->hears(
            'stop',
            function (BotMan $bot) {
                $bot->reply('I will stop our conversation.');
            }
        )->stopsConversation();

        $botman->hears(
            'question',
            function (BotMan $bot) {
                $bot->startConversation(new QuestionConversation());
            }
        );

      
        $botman->fallback(
            function (BotMan $bot) {
                $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
            }
        );

        $botman->listen();

        return new Response();
        
    }

    #[Route('/frame', name: 'Botframe')]
    public function chatframe(): Response
    {
        return $this->render('chat/frame.html.twig');
    }

    private function fetchWeatherData(string $location): stdClass
    {
       
        $url = 'http://api.weatherstack.com/current?access_key=18895c6bcedd7b4a6194ffd07400025a&query=' . urlencode($location);

        return json_decode(file_get_contents($url));
    }

    private function fetchGiphyGif(string $name): Image
    {
        $url = sprintf('https://api.giphy.com/v1/gifs/search?api_key=zlPPjtJejAAj56KPc5iCjIDqeMsgiD2m&q=%s&limit=1', urlencode($name));
        $response = json_decode(file_get_contents($url));

        return new Image($response->data[0]->images->downsized_large->url);
    }
}
