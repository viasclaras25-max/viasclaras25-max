// Inicializar Mapbox
mapboxgl.accessToken = 'pk.eyJ1IjoibWFyaWkyMyIsImEiOiJjbTFhM2Q0OG4wODJlMnRvbTQ4a2M3anc0In0.qJTjB1HweqzdnslPp6ocQw';

const map = new mapboxgl.Map({
  container: 'map',
  style: 'mapbox://styles/mapbox/streets-v12',
  center: [-80.97, 8.10],
  zoom: 13
});

// Variables globales
let userLocation = null;
let destinationLocation = null;
let userMarker = null;
let locationMarker = null;
let routeLayerId = 'routeLine';

// Control de geolocalización
const geolocate = new mapboxgl.GeolocateControl({
  positionOptions: { enableHighAccuracy: true },
  trackUserLocation: true,
  showUserLocation: false
});
map.addControl(geolocate);
map.addControl(new mapboxgl.NavigationControl());
map.addControl(new mapboxgl.ScaleControl());

// Botón de geolocalización
document.getElementById('geolocate-btn').addEventListener('click', () => {
  geolocate.trigger();
});

// Evento de geolocalización exitosa
geolocate.on('geolocate', (e) => {
  userLocation = {
    lng: e.coords.longitude,
    lat: e.coords.latitude
  };

  // Eliminar marcador anterior si existe
  if (userMarker) userMarker.remove();

  // Crear nuevo marcador de usuario
  userMarker = new mapboxgl.Marker({ color: '#4CAF50' })
    .setLngLat([userLocation.lng, userLocation.lat])
    .setPopup(new mapboxgl.Popup().setHTML('Tu ubicación'))
    .addTo(map);

  // Centrar mapa en la ubicación del usuario
  map.flyTo({ center: [userLocation.lng, userLocation.lat], zoom: 15 });

  // Si ya hay destino, trazar la ruta
  if (destinationLocation) {
    drawRoute(userLocation, destinationLocation);
  }
});

