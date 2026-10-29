const express = require('express');
const os = require('node:os');

const app = express();
const port = Number(process.env.PORT || 80);
const version = process.env.APP_VERSION || '1.0.0';
const phrases = [
  'Get ready to be inspired…',
  'See rejection as redirection.',
  'There is beauty in simplicity.',
  "You can't be late until you show up.",
  "Maybe life is testing you. Don't give up.",
  'Impossible is just an opinion.',
  'Alone or not you gonna walk forward.',
];

app.get('/', (_request, response) => {
  const number = Math.floor(Math.random() * phrases.length);
  response.type('text/plain').send(`${phrases[number]} - Container Id: ${os.hostname()} - Version: ${version}`);
});

app.get('/health', (_request, response) => {
  response.status(200).json({ status: 'ok' });
});

if (require.main === module) {
  app.listen(port, '0.0.0.0', () => console.log(`Randomquotes listening on ${port}`));
}

module.exports = { app, phrases };
