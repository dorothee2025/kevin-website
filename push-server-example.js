// Simple Node.js example using web-push to send notifications
// Usage: npm install express body-parser web-push
// Run: node push-server-example.js

const express = require('express');
const bodyParser = require('body-parser');
const webpush = require('web-push');

const app = express();
app.use(bodyParser.json());

// TODO: generate keys with web-push generate-vapid-keys
const VAPID_PUBLIC = '<YOUR_VAPID_PUBLIC_KEY>';
const VAPID_PRIVATE = '<YOUR_VAPID_PRIVATE_KEY>';

webpush.setVapidDetails('mailto:you@example.com', VAPID_PUBLIC, VAPID_PRIVATE);

let savedSubscription = null;

app.post('/subscribe', (req, res) => {
  savedSubscription = req.body;
  res.status(201).json({});
});

app.post('/send', async (req, res) => {
  if (!savedSubscription) return res.status(400).json({ error: 'No subscription' });
  try{
    await webpush.sendNotification(savedSubscription, JSON.stringify({ title: 'CS DREAM', body: req.body.message || 'Hello from server', url: '/' }));
    res.json({ok:true});
  }catch(e){ res.status(500).json({error:e.message}); }
});

app.listen(3000, ()=>console.log('Push server listening on :3000'));
