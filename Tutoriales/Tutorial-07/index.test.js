const assert = require('node:assert/strict');
const { after, test } = require('node:test');
const { app, phrases } = require('./index');

const server = app.listen(0, '127.0.0.1');
const baseUrl = new Promise((resolve) => server.once('listening', () => {
  resolve(`http://127.0.0.1:${server.address().port}`);
}));

after(() => new Promise((resolve, reject) => server.close((error) => error ? reject(error) : resolve())));

test('root returns a known random phrase and container metadata', async () => {
  const response = await fetch(await baseUrl);
  const body = await response.text();

  assert.equal(response.status, 200);
  assert.ok(phrases.some((phrase) => body.startsWith(`${phrase} - Container Id: `)));
  assert.match(body, / - Version: 1\.0\.0$/);
});

test('health endpoint returns a successful JSON status', async () => {
  const response = await fetch(`${await baseUrl}/health`);

  assert.equal(response.status, 200);
  assert.deepEqual(await response.json(), { status: 'ok' });
});
