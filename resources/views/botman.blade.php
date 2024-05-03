<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>How to install Botman Chatbot in Laravel ?</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
        </style>
    </head>
    <body>

    </body>
  
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css"> -->
    <!-- <script>
     var botmanWidget = {
         aboutText: 'ssdsd',
         introMessage: "✋ Hi! I'm from ChatBot. how can i help you."
     };
    </script>
  
    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script> -->
    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    <script>
        var botmanWidget = {
            frameEndpoint: '<?php echo url('botdemo/chatserver1');?>',
            aboutText: 'ssdsd',
            introMessage: "✋ Hi! I'm from ChatBot. How can I help you? please write Hi for further process.",
            title:'Chat Bot',
            mainColor:'#383838',
            bubbleBackground:'#c02026',
            headerTextColor: '#fff',
        };

        window.addEventListener('load', function () {
            botmanWidget.chat.on('message', function(message) {
                if (message.isFromUser) {
                    fetch('/botman', { // Route to send messages
                        method: 'POST',
                        body: JSON.stringify({message: message.text}),
                        headers: { 'Content-Type': 'application/json' }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Handle bot responses (optional)
                        // For example, you could update the chat UI with the bot's message
                    })
                    .catch(error => console.error(error));
                }
            });
        });
    </script>
      
</html>