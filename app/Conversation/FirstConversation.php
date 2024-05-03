<?php

namespace App\Conversation;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Illuminate\Support\Facades\Validator;

class FirstConversation extends Conversation
{
    protected $firstname;
  //  public $botman;
    protected $email;
    //not work not take 3 sec 
    // public function __construct()
    // {
    //     $this->botman = app('botman');
    // }
    public function askFirstname()
    {
        $this->ask('Hello! What is your firstname?', function(Answer $answer) {
            $botman = app('botman');
            // Save result
            $this->firstname = $answer->getText();
            $botman->typesAndWaits(3);
            $this->say('Nice to meet you '.$this->firstname);
            $this->askEmail();

            $this->bot->userStorage()->save([
                'Name' => $answer->getText(),
            ]);
        });
    }

    public function askEmail()
    {
        $this->ask('One more thing - what is your email?', function(Answer $answer) {

           
            $validator = validator::make(['email' => $answer->getText()], [
                'email' => 'email:rfc,dns',
            ]);
    
            if ($validator->fails()) {
               // return $this->repeat('That doesn\'t look like a valid email. Please enter a valid email.');
                $initialMessage = OutgoingMessage::create('That doesn\'t look like a valid email. Please enter a valid email.');
                $this->bot->reply($initialMessage); // Send the initial message

                return $this->askEmail();
            }
    
            $this->bot->userStorage()->save([
                'email' => $answer->getText(),
            ]);
            
            $this->say('Great - that is all we need, '.$this->firstname);
            $this->askMobile();

            //$this->bot->startConversation(new SelectServiceConversation());
        });
        // $this->ask('One more thing - what is your email?', function(Answer $answer) {
        //     // Save result
        //     $this->email = $answer->getText();

        //     $this->say('Great - that is all we need, '.$this->firstname);
        // });
    }

    public function askMobile()
{
    $this->ask('Great. What is your mobile?', function(Answer $answer) {

        $validator = Validator::make(['mobile' => $answer->getText()], [
                 'mobile' => 'regex:/^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$/',
         ]);

        if ($validator->fails()) {
            return $this->repeat('That doesn\'t look like a valid Phone number. Please enter a valid Phone Number.');

        }

        $this->bot->userStorage()->save([
            'mobile' => $answer->getText(),
        ]);

        $this->say('Great!');

        $this->bot->startConversation(new SelectServiceConversation()); // Trigger the next conversation
    });
}
    public function run()
    {
        $this->askFirstname();
    }
}