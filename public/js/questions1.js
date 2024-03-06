// Retrieve the JSON formatted questions from the data attribute
let jsonFormattedQuestions = document.getElementById('questions-data').getAttribute('data-json');

// Parse the JSON string into a JavaScript object
let questions = JSON.parse(jsonFormattedQuestions);