const API_KEY = 'AIzaSyCIVZZ_-K98jV5R0eg-qv3WZhjXHF6_Vqw';
const CALLBACK_NAME = 'gmapsReady';

let initialized = !!window.google;
let resolveInitPromise;
let rejectInitPromise;
// This promise handles the initialization
// status of the google maps script.
const initPromise = new Promise((resolve, reject) => {
  resolveInitPromise = resolve;
  rejectInitPromise = reject;
});

export default function init() {
  // If Google Maps already is initialized
  // the `initPromise` should get resolved
  // eventually.
  if (initialized) return initPromise;

  initialized = true;
  // The callback function is called by
  // the Google Maps script if it is
  // successfully loaded.
  window['initMap'] = () => resolveInitPromise(window.google);

  // We inject a new script tag into
  // the `<head>` of our HTML to load
  // the Google Maps script.
  const script = document.createElement('script');
  script.async = true;
  script.defer = true;
  // script.src = `https://maps.googleapis.com/maps/api/js?key=${API_KEY}&callback=${CALLBACK_NAME}`;
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCIVZZ_-K98jV5R0eg-qv3WZhjXHF6_Vqw&callback=initMap"
  script.onerror = rejectInitPromise;
  document.querySelector('head').appendChild(script);

  return initPromise;
}