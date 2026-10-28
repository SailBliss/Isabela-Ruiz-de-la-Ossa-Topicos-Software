'use strict';

const express = require('express');

const app = express();
const phrases = [
  'Get ready to be inspired…',
  'See rejection as redirection.',
  'There is beauty in simplicity.',
  'You can’t be late until you show up.',
  'Maybe life is testing you. Don’t give up.',
  'Impossible is just an opinion.',
  'Alone or not you gonna walk forward.',
];

function getRandomPhrase(random = Math.random) {
  const index = Math.floor(random() * phrases.length);
  return phrases[index];
}

app.get('/', (_request, response) => {
  response.type('text/plain').send(getRandomPhrase());
});

if (require.main === module) {
  const port = Number.parseInt(process.env.PORT || '3000', 10);
  app.listen(port, '0.0.0.0', () => {
    console.log(`Random Quotes listening on port ${port}`);
  });
}

module.exports = { app, getRandomPhrase, phrases };
