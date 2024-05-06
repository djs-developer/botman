<?php
namespace App\Conversation;

use App\Models\chatbot;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class SelectServiceConversation extends Conversation
{
      public $data;

    public function __construct()
    {
        $this->data = ["question" => "What kind of Service you are looking for?",
        "homequestion" => "'What kind of Home you are looking for?",
    ];
    }
   // protected $selectedText;
    public function askService()
    {
        $question = Question::create($this->data['question'])
        ->callbackId('select_service')
        ->addButtons([
            Button::create('Home Loan')->value('Home Loan'),
            Button::create('Car Loan')->value('Car Loan'),
            Button::create('Gold Loan')->value('Gold Loan'),
        ]);

    $this->ask($question, function(Answer $answer) {
        if ($answer->isInteractiveMessageReply()) {
           // $this->bot->userStorage()->save([
                //'service' => $answer->getValue(),
                $selectedValue = $answer->getValue(); // will be give value of button
                $selectedText = $answer->getText(); //will give button text
                $this->say('so You click '.$selectedText);
                //$selected = $answer->getText(); // Extract the mobile number
                $id = $this->bot->getUser()->getId();
            // Create a new UserMobile instance
            $userMobile = new chatbot([
                'user_id' =>$id, // Get user ID from Botman message
                'question'=>$this->data['question'],
                'answer' => $selectedText,
            ]);
            $userMobile->save();


                $this->bot->userStorage()->save([
                    'question'=>$this->data['question'],
                    'answer' => $answer->getText(),
                ]);
                if($selectedText == 'Home Loan')
                {
                            $questionHome = Question::create($this->data['homequestion'])
                            ->callbackId('select_service')
                            ->addButtons([
                                        Button::create('Duplex')->value('Duplex'),
                                        Button::create('Bungalow')->value('Bungalow'),
                                        Button::create('Townhome')->value('Townhome'),
                                        Button::create('Apartment')->value('Apartment'),
                            ]);
                          
                            $this->ask($questionHome,function(Answer $answerhome){
                                if ($answerhome->isInteractiveMessageReply()) {
                                    $selectedhome = $answerhome->getValue(); // will be either 'yes' or 'no'
                                    $selectedhometext = $answerhome->getText();
                                    $this->say('so You click '.$selectedhometext);
                                    $id = $this->bot->getUser()->getId();
                                    // Create a new UserMobile instance
                                    $userMobile = new chatbot([
                                        'user_id' =>$id, // Get user ID from Botman message
                                        'question'=>'What kind of Home you are looking for?',
                                        'answer' => $selectedhometext,
                                    ]);
                                    $userMobile->save();
                                    // $this->bot->userStorage()->save([
                                    //   //  'question'=>'What kind of Home you are looking for?',
                                    //     'What kind of Home you are looking for?' => $answerhome->getText(),
                                    // ]);
                                }
                            });
                }elseif($selectedText == 'Car Loan'){

                            $questioncar = Question::create('What kind of Car you are looking for?')
                            ->callbackId('select_service')
                            ->addButtons([
                                        Button::create('Car')->value('Car'),
                                        Button::create('Bus')->value('Bus'),
                                        Button::create('Bike')->value('Bike'),
                                        Button::create('truck')->value('truck'),
                            ]);

                            $this->ask($questioncar,function(Answer $answercar){
                                if ($answercar->isInteractiveMessageReply()) {
                                    $selectedcar = $answercar->getValue(); // will be either 'yes' or 'no'
                                    $selectedcartext = $answercar->getText();
                                    $this->say('so You click '.$selectedcartext);
                                    $id = $this->bot->getUser()->getId();
                                    // Create a new UserMobile instance
                                    $userMobile = new chatbot([
                                        'user_id' =>$id, // Get user ID from Botman message
                                        'question'=>'What kind of Car you are looking for?',
                                        'answer' => $selectedcartext,
                                    ]);
                                    $userMobile->save();
                                    $this->bot->startConversation( new userdataConversation());
                                }
                            });
                }elseif($selectedText == 'Gold Loan')
                {
                            $questiongold = Question::create('What kind of Gold you are looking for?')
                            ->callbackId('select_service')
                            ->addButtons([
                                        Button::create('Yellow Gold')->value('Yellow Gold'),
                                        Button::create('Rose Gold')->value('Rose Gold'),
                            ]);

                            $this->ask($questiongold,function(Answer $answergold){
                                if ($answergold->isInteractiveMessageReply()) {
                                    $selectedgold = $answergold->getValue(); // will be either 'yes' or 'no'
                                    $selectedgoldtext = $answergold->getText();
                                    $this->say('so You click '.$selectedgoldtext);
                                    $id = $this->bot->getUser()->getId();
                                    // Create a new UserMobile instance
                                    $userMobile = new chatbot([
                                        'user_id' =>$id, // Get user ID from Botman message
                                        'question'=>'What kind of Gold you are looking for?',
                                        'answer' => $selectedgoldtext,
                                    ]);
                                    $userMobile->save();


                                    if($selectedgoldtext == 'Rose Gold')
                            {
                                $this->ask('Do you Want to Buy Rose Gold ?Say YES or NO', [
                                            [
                                                'pattern' => 'yes|yep',
                                                'callback' => function (Answer $answer) {
                                                    $userans = $answer->getText();
                                                   // dd($userans);
                                                    $this->say('your Rose Gold Amount is 10,000');
                                                    return $this->respond([]);
                                                }
                                            ],
                                            [
                                                'pattern' => 'nah|no|nope',
                                                'callback' => function (Answer $answer) {
                                                    $userans = $answer->getText();
                                                    $this->say('Sorry, you select no we can not help you for next process.');
                                                }
                                            ]
                                        ]);
                                    //     $id = $this->bot->getUser()->getId();
                                    // // Create a new UserMobile instance
                                    // $userMobile = new chatbot([
                                    //     'user_id' =>$id, // Get user ID from Botman message
                                    //     'question'=>'Do you Want to Buy Rose Gold ?Say YES or NO',
                                    //     'answer' => $userans,
                                    // ]);
                                    // $userMobile->save();
                            }
                                }
                            });
                            
                }else
                {
                        $this->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
                }
           // ]);
        }
    });
   
    }
//working like questoion is Shall we proceed? Say YES or NO
//user ans yes
//give - Okay - we'll keep going
//     public function askNextStep()
// {
//     $this->ask('Shall we proceed? Say YES or NO', [
//         [
//             'pattern' => 'yes|yep',
//             'callback' => function () {
//                 $this->say('Okay - we\'ll keep going');
//             }
//         ],
//         [
//             'pattern' => 'nah|no|nope',
//             'callback' => function () {
//                 $this->say('PANIC!! Stop the engines NOW!');
//             }
//         ]
//     ]);
// }

    public function run()
    {
        $this->askService();
    }
}