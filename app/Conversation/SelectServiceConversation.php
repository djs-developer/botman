<?php
namespace App\Conversation;

use App\Models\chatbot;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

use function Termwind\ask;

class SelectServiceConversation extends Conversation
{
    public $data;
    public $questionMap;
    public $inputanswer;
    public function __construct()
    {
            
            $this->data = [
                    'questions' => [
                      [
                        'id'=>1,
                        'type'=>'select',
                        'question' => 'What kind of Service you are looking for?',
                        'options' =>[
                                      ['id' => 11, 'value' => 'Home Loan', 'nextQuestion' => 2],
                                     ['id'=>12 ,'value'=> 'Car Loan', 'nextQuestion' => 3],
                                     ['id'=>13, 'value'=> 'Gold Loan'],],
                        'time'=>0,
                        'mainquestion' => 12,
                      ],
                      [
                        'id'=>2,
                        'type'=>'select',
                        'question' => 'What kind of Home you are looking for?',
                        'options' =>[ ['id'=>21, 'value'=>'Duplex','nextQuestion'=>5],
                                     ['id'=>22, 'value'=> 'Bungalow','nextQuestion'=>6 ],
                                     ['id'=>23, 'value'=>'Townhome','nextQuestion'=>8],
                                     ['id'=>24, 'value'=>'Apartment'],],
                        'time'=>2,
                         'mainquestion' => 12,
                      ],
                      [
                        'id'=>3,
                        'type'=>'select',
                        'question' => 'What kind of Car you are looking for?',
                        'options' =>[ ['id'=>31, 'value'=>'car','nextQuestion'=>11],
                                    ['id'=>32, 'value'=> 'Bus'],
                                    ['id'=>33, 'value'=> 'Bike'],
                                    ['id'=>34, 'value'=> 'Truck'],],
                        'time'=>2,
                      ],
                      [
                        'id'=>4,
                        'type'=>'select',
                        'question' => 'What kind of Gold you are looking for?',
                        'options' =>[ ['id'=>41, 'value'=>'Yellow Gold'],
                                    ['id'=>42, 'value'=> 'Rose Gold','nextQuestion'=>5],],
                        'time'=>2,
                        'mainquestion' => 8,
                      ],
                      [
                        'id'=>5,
                        'type'=>'select',
                        'question' => 'are you want to by gold rose gold ?',
                        'options' =>[ ['id'=>51, 'value'=>'Yes' ],
                                    ['id'=>52, 'value'=> 'No'],],
                        'time'=>2,
                      ],
                      [
                        'id'=>6,
                        'type'=>'checkbox',
                        'question' => 'are you want to Quite conversation?',
                        'options' =>[ ['id'=>61, 'value'=>'Yes'],
                                    ['id'=>62, 'value'=> 'No'],],
                        'time'=>2,
                      ],
                      [
                        'id'=>8,
                        'type'=>'select',
                        'question' => 'your name is ?',
                        'options' =>[ ['id'=>81, 'value'=>'nency','nextQuestion'=>9],
                                    ['id'=>82, 'value'=> 'vraj'],],
                        'time'=>2,
                      ],
                      [
                        'id'=>9,
                        'type'=>'select',
                        'question' => 'what is your fav food?',
                        'options' =>[ ['id'=>91, 'value'=>'pizza','nextQuestion'=>10],
                                    ['id'=>92, 'value'=> 'panipuri'],],
                        'time'=>2,
                      ],
                      [
                        'id'=>10,
                        'type'=>'select',
                        'question' => 'what is your fav game?',
                        'options' =>[ ['id'=>101, 'value'=>'hocky'],
                                    ['id'=>102, 'value'=> 'football'],],
                        'time'=>2,
                      ],
                      [
                        'id'=>11,
                        'type'=>'select',
                        'question' => 'what do you want?',
                        'options' =>[ ['id'=>111, 'value'=>'cake'],
                                    ['id'=>112, 'value'=> 'chess cake'],
                                    ['id'=>113, 'value'=> 'pastry'],
                                    ['id'=>114, 'value'=> 'none'],],
                        'time'=>2,
                      ],
                      [
                        'id'=>7,
                        'type'=>'select',
                        'question' => 'what type of city are you looking for?',
                        'options' =>[ ['id'=>71, 'value'=>'Ahmedabad'],
                                    ['id'=>72, 'value'=> 'Mumbai'],
                                    ['id'=>73, 'value'=> 'Panjab'],
                                    ['id'=>74, 'value'=> 'Kerela'],],
                        'time'=>2,
                      ],
                      [
                        'id'=>12,
                        'type'=>'input',
                        'question' => 'what kind of service we provide to you?',
                        'time'=>2,
                        'validation'=>["type"=> "string", 
                        "pattern"=>'/^[a-zA-Z0-9]+$/',
                       // ^[a-zA-Z0-9\s]+$/    allow white space
                        "required"=> true,
                        "max"=> 20 ],
                        'mainquestion'=>13,
                      ],
                      [
                        'id'=>13,
                        'type'=>'input',
                        'question' => 'ok now tell me how can i help you?',
                        'time'=>2,
                        'validation'=>["type"=> "string", 
                        "required"=> true,],
                        'mainquestion'=>1,
                      ],
                    ],
                  ];
                  usort($this->data['questions'], function ($a, $b) {
                    return $a['id'] <=> $b['id'];
                });
                  $this->questionMap = [];
                  foreach ($this->data['questions'] as $index => $question) {
                      $this->questionMap[$question['id']] = $index;
                  }  
                   
    }
    
    public function askQuestion($currentQuestionIndex = 1) {
    
      if (!isset($this->questionMap[$currentQuestionIndex])) {
        $this->say('Invalid question ID: ' . $currentQuestionIndex);
        return;
    }

    $currentQuestionIndex = $this->questionMap[$currentQuestionIndex];
      $question = $this->data['questions'][$currentQuestionIndex];
      $waitTime = isset($question['time']) ? $question['time'] : 0;
        switch ($question['type']) {
          case 'select':
            $this->askSelectQuestions($currentQuestionIndex,$waitTime);
            break;
          case 'checkbox':
            $this->askCheckBoxQuestion($question,$waitTime); // Pass the question for specific handling
            break;
          case 'input':
            $this->askInputQuestion($question,$waitTime); // Pass the question for specific handling
            break;
          default:
            // Handle unknown question types gracefully (e.g., log a warning)
            $this->say('Unknown question type: ' . $question['type']);
        } 
        if ($currentQuestionIndex >= count($this->data['questions'])) {
          $this->say('Thank you for answering all the questions!');
          return;
        }
    }
     

public function askSelectQuestions($currentQuestionIndex,$waitTime) {
  $question = $this->data['questions'][$currentQuestionIndex];

  $options = [];
  foreach ($question['options'] as $option) {
      $button = Button::create($option['value'])
      ->value($option['id']);
      $options[] = $button;
      //$optionTextMap[$option['id']] = $option['value'];
  }

  $startquestion = Question::create($question['question'])
      ->fallback('Unable to create a new database')
      ->callbackId('create_database')
      ->addButtons($options);

  $this->ask($startquestion, function (Answer $answer) use ($currentQuestionIndex,$question,$options,$waitTime) {
      if ($answer->isInteractiveMessageReply()) {
          $selectedValue = $answer->getValue();
          $selectedText = $this->getoptiontext($currentQuestionIndex,$options,$selectedValue);
          $botman = app('botman');
          $botman->typesAndWaits($waitTime);
          $this->say('Your answer is ' . $selectedText . '.');
          //perfect working for save data into databse comment bec tesing othe code
          $id = $this->bot->getUser()->getId();
          $saveintodatabase = new chatbot([
                        'user_id' =>$id, // Get user ID from Botman message
                        'question'=>$question['question'],
                        'answer' => $selectedText,
                    ]);
          $saveintodatabase->save();
          $nextQuestionId = null;
          $selectedValue = $answer->getValue();
          foreach ($question['options'] as $option) {
            $castedId = (int) $option['id']; // Cast to integer (optional)
            $trimmedId = trim($castedId);
            
              if ($trimmedId === $selectedValue) {
                  $nextQuestionId = isset($option['nextQuestion']) ? $option['nextQuestion'] : null;
              }
          }
         
          if ($nextQuestionId !== null) {
            $botman = app('botman');
            $botman->typesAndWaits($waitTime);
            $this->askQuestion($nextQuestionId);
          } else {
            if (isset($question['mainquestion'])) {
              $botman = app('botman');
              $botman->typesAndWaits($waitTime);
              $this->askQuestion($question['mainquestion']);
            }
            //$this->say('There seems to be no defined next question for this option. Please contact support.');
          }
      }
  });
}
  
public function askCheckBoxQuestion()
{
    $this->say('this is checkbox method');
}
 
public function askInputQuestion($question,$waitTime) {

  $this->ask($question['question'], function(Answer $answer) use($question,$waitTime) {  
   
    $this->inputanswer = $answer->getText();
    $errors = $this->validation($question, $this->inputanswer);
    
    if (count($errors) > 0) {  
      foreach ($errors as $error) {
        $this->say($error);
      }
      return ; // Exit the callback function if there are errors
    }
    //perfect working for save data into databse comment bec tesing othe code
    $id = $this->bot->getUser()->getId();
    $saveintodatabase = new chatbot([
      'user_id' =>$id, // Get user ID from Botman message
      'question'=>$question['question'],
      'answer' => $this->inputanswer,
  ]);
  $saveintodatabase->save();
    $this->say('Great - that is all we need, ');
    if ($this->inputanswer !== null && isset($question['mainquestion'])) {
      $botman = app('botman');
      $botman->typesAndWaits($waitTime);
      $this->askQuestion($question['mainquestion']);
    }
  });
}

public function validation($question, $inputanswer) {
  $validationRules = $question['validation'];
  $errors = [];
 
  if (!isset($validationRules['required']) || !$inputanswer) {
      $errors[] = 'This field is required.'; 
    }

    if (isset($validationRules['type']) && $validationRules['type'] === 'string') {
        if (isset($validationRules['pattern'])) {
          $pattern = $validationRules['pattern']; // Get the pattern from validation rules
          if (!preg_match($pattern, $inputanswer)) {
            $errors[] = 'This field requires a value matching the pattern.'; // Customize error message
          }
        }
      
    }
  
  
  if (isset($validationRules['max']) && strlen($inputanswer) > $validationRules['max']) {
      $errors[] = sprintf('Input must be less than %d characters.', $validationRules['max']);
  }

  return $errors;
}

public function getoptiontext($currentQuestionIndex,$options,$selectedValue)
{
  if ($currentQuestionIndex) {
    $questionData = $this->data['questions'][$currentQuestionIndex];
    $options  = $questionData['options'];

    foreach ($options as $option) {
      if ($option['id'] == $selectedValue) {
        return $option['value'];
      }
    }
    return 'option not get';   
}elseif($currentQuestionIndex == 0)
{
  $questionData = $this->data['questions'][$currentQuestionIndex];
    $options  = $questionData['options'];

    foreach ($options as $option) {
      if ($option['id'] == $selectedValue) {
        return $option['value'];
      }
    }
    return 'option not get'; 
}
}

  
    public function run()
    {
        $this->askQuestion();
    }
}