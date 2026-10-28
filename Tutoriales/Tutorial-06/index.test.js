'use strict';

const assert = require('node:assert/strict');
const { after, before, test } = require('node:test');
const { app, getRandomPhrase, phrases } = require('./index');

let server;
let baseUrl;

before(async () => {
  server = app.listen(0, '127.0.0.1');
  await new Promise((resolve, reject) => {
    server.once('listening', resolve);
    server.once('error', reject);
  });
  baseUrl = `http://127.0.0.1:${server.address().port}`;
});

after(async () => {
  if (server) {
    await new Promise((resolve, reject) => {
      server.close((error) => (error ? reject(error) : resolve()));
    });
  }
});

test('contains the seven phrases from the tutorial', () => {
  assert.equal(phrases.length, 7);
});

test('selects the first and last phrase at the random boundaries', () => {
  assert.equal(getRandomPhrase(() => 0), phrases[0]);
  assert.equal(getRandomPhrase(() => 0.999999), phrases[6]);
});

test('GET / responds with one phrase as plain text', async () => {
  const response = await fetch(`${baseUrl}/`);
  const body = await response.text();

  assert.equal(response.status, 200);
  assert.match(response.headers.get('content-type'), /^text\/plain/);
  assert.ok(phrases.includes(body));
});
