// var botmanWidget = {
//     frameEndpoint: '/chat', // Your custom route
//     // Other widget configurations...
//   };
  
//   window.addEventListener('load', function () {
  
//     document.addEventListener('DOMContentLoaded', function() {
//       botmanWidget.chat.on('message', function(message) {
//         if (message.isFromUser) {
//           fetch('/chat', {
//             method: 'POST',
//             body: JSON.stringify({message: message.text}),
//             headers: { 'Content-Type': 'application/json' }
//           })
//           .then(response => response.json())
//           .then(data => {
//             console.log(data);
//             // Handle bot responses (optional)
//           })
//           .catch(error => console.error(error));
//         }
//       });
//     });
//   });

  
  
  