<?php

namespace App\Http\Controllers;

use App\Conversation\FirstConversation as ConversationFirstConversation;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;
class botmanController extends  Conversation
{
    // public function callback($botman)
    // {
    //     //$botman = app('botman');
    //     $botman->fallback(function($bot) {
    //         $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
    //     }); 
    
    // }

    public function handle( )
    {
        //$conversation = new GlobalFirstConversation; // Replace with your conversation class name

        // dd('1111111111');
         $botman = app('botman');
         $botman->hears('{message}', function($botman, $message) {
            if ($message == 'hi') {
                $conversation = new ConversationFirstConversation; 
                //dd('gdf');
                        // $this->startConversation(new app\Botman\FirstConversation);
                        //$message->startConversation(new GlobalFirstConversation);
                        $botman->startConversation($conversation); 
                     }else
                     {
                      
                            $botman->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
                     
                     }
         });
          $botman->listen();
        // $botman->hears('hi', function($bot) {
        //     dd('gdf');
        //     $bot->startConversation(new BotmanStartconversation);
        // });
        // $botman->hears('{message}', function($botman, $message) {
  
        //     if ($message == 'hi') {
        //         $this->askName($botman);
        //     }
        //     else{
        //        // $botman->reply($callback);
        //         //this is not working 
        //         return $botman->callback();
        //     }
  
        // });
  
        // $botman->listen();
    }
  
    /**
     * Place your BotMan logic here.
     */
    public function askName()
    {
        $botman = app('botman');
        $botman->ask('Hello! What is your Name?', function(Answer $answer) {
  
            $name = $answer->getText();

            $this->say('Nice to meet you '.$name);
           // $this->askEmail();
        });
       
    }

    public function askEmail()
    {
        $botman = app('botman');
        $botman->ask('Can you give your Email?', function(Answer $answer) {
  
            $phone = $answer->getText();
        
            $this->say('thnak you for you answer '.$phone);
        });
    }

    public function run()
    {
        $this->askName();
    }
}
