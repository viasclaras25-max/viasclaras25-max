// Inicializar Mapbox (reemplaza 'TU_TOKEN_MAPBOX' con tu API key)
    mapboxgl.accessToken = 'pk.eyJ1IjoibWFyaWkyMyIsImEiOiJjbTFhM2Q0OG4wODJlMnRvbTQ4a2M3anc0In0.qJTjB1HweqzdnslPp6ocQw';
    const map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v12',
      center: [-80.97, 8.10], // Centro inicial (aproximado de tus ubicaciones)
      zoom: 13
    });

    // Variables para marcadores
    let locationMarker = null;
    let userMarker = null;

    // Control de geolocalización
    const geolocate = new mapboxgl.GeolocateControl({
      positionOptions: {
        enableHighAccuracy: true
      },
      trackUserLocation: true,
      showUserLocation: false // Lo manejaremos manualmente
    });
    map.addControl(geolocate);
    map.addControl(new mapboxgl.NavigationControl());
    map.addControl(new mapboxgl.ScaleControl());

    // Botón de geolocalización
    document.getElementById('geolocate-btn').addEventListener('click', () => {
      geolocate.trigger();
    });

    //  geolocalizacion
    geolocate.on('geolocate', (e) => {
      const userLocation = {
        lng: e.coords.longitude,
        lat: e.coords.latitude
      };
      
      // Eliminar marcador anterior si existe
      if (userMarker) userMarker.remove();
      
      // Crear nuevo marcador de usuario
      userMarker = new mapboxgl.Marker({
        color: '#4CAF50',
        draggable: false
      })
        .setLngLat([userLocation.lng, userLocation.lat])
        .setPopup(new mapboxgl.Popup().setHTML('<strong>Tu ubicación</strong>'))
        .addTo(map);
      
      // Centrar mapa en la ubicación del usuario
      map.flyTo({
        center: [userLocation.lng, userLocation.lat],
        zoom: 15
      });
    });

    // Manejar cambios en el selector de ubicaciones
    document.getElementById('location-selector').addEventListener('change', function(e) {
      if (!e.target.value) return;
      
      const [name, lat, lng] = e.target.value.split(',');
      
      // Animación para moverse al nuevo lugar
      map.flyTo({
        center: [parseFloat(lng), parseFloat(lat)],
        zoom: 15,
        essential: true
      });
      
      // Eliminar marcador anterior si existe
      if (locationMarker) locationMarker.remove();
      
      // Crear nuevo marcador con popup
      locationMarker = new mapboxgl.Marker({
        color: '#3a86ff',
        draggable: false
      })
        .setLngLat([parseFloat(lng), parseFloat(lat)])
        .setPopup(new mapboxgl.Popup().setHTML(`<strong>${name}</strong><br>${e.target.options[e.target.selectedIndex].text}`))
        .addTo(map);
      
      // Abrir popup automáticamente
      locationMarker.togglePopup();
    });

    // Cargar mapa completamente antes de interacciones
    map.on('load', () => {
      console.log('Mapa cargado correctamente');
    });

