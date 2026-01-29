const webpush = require('web-push');

// VAPID keys
const publicVapidKey = 'BCKkwP8zd3yHuTad6AjrKeVXTPCMw9xBMi_vfVXf7yt7Ax7vqLZz77w9worMz6Y0odD4TJVl0Zmq59G5CkKUUKY';
const privateVapidKey = '7UdpEiEeHXfEEmKuNnBPJXR9Kl8cvIZurTYOmMqT-bo';

webpush.setVapidDetails(
    'mailto:example@yourdomain.org',
    publicVapidKey,
    privateVapidKey
);

// REPLACE THIS WITH THE SUBSCRIPTION OBJECT FROM YOUR BROWSER CONSOLE
// You can find this by running the site, checking the console, and copying the JSON string.
const subscription = {}; 

const payload = JSON.stringify({
    title: 'Hello from Node.js!',
    body: 'This is a test notification sent via web-push.',
    icon: '/assets/images/knhs.webp'
});

if (Object.keys(subscription).length === 0) {
    console.error('Error: You must paste the subscription object from the browser console into the "subscription" variable in this file.');
    process.exit(1);
}

webpush.sendNotification(subscription, payload)
    .catch(err => console.error(err));

console.log('Notification sent (if subscription is valid)...');
