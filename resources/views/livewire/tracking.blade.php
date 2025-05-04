<div>
    @push('scripts')
        <script>
            let view_map;
            let markers = [];
            let markerData = [];

            $(document).ready(function() {
                initializeSelect2();

                setInterval(() => {
                    getTravelAttendanceLoc(1);
                }, 500);

                view_map = initMap();
            });

            function initializeSelect2() {
                $('.select2-department').select2({
                    placeholder: "Filter by department",
                    allowClear: true
                });
            }

            $('.travel_filter').on('change', function() {
                const travelId = $(this).val();

                if (travelId) {
                    getTravelAttendanceLoc(travelId);
                    if (markerData.length > 0) {
                        const firstUser = markerData[0];
                        view_map.setView([firstUser.lat, firstUser.lng], 15);
                    }
                } else {
                    getTravelAttendanceLoc(null);
                }
            });

            $('.search-employee').on('keyup', function() {
                const searchValue = $(this).val();

                if (searchValue.length > 0) {
                    searchMarkerByName(searchValue);
                }
            });

            function getTravelAttendanceLoc(travel_id) {
                @this.call('getTravelAttendance', travel_id).then(response => {
                    console.log(response);

                    updateMarkers(view_map, response);
                });
            }

            function initMap() {
                const view_map = L.map('view_map').setView([6.497396, 124.847160], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(view_map);

                L.Control.geocoder({
                    defaultMarkGeocode: false
                }).on('markgeocode', function(e) {
                    const latlng = e.geocode.center;
                    view_map.setView(latlng, 11);
                }).addTo(view_map);

                return view_map;
            }

            function updateMarkers(view_map, users = []) {
                markerData = users;

                // Clear existing circles
                view_map.eachLayer(layer => {
                    if (layer instanceof L.Circle) {
                        view_map.removeLayer(layer);
                    }
                });

                users.forEach(user => {
                    const existingMarker = markers.find(marker => marker.userId === user.id);

                    if (existingMarker) {
                        // Smoothly move the marker to the new location
                        animateMarker(existingMarker.marker, [user.lat, user.lng]);
                    } else {
                        // Create a new marker if it doesn't exist
                        const newMarker = createMarker(view_map, user);
                        markers.push({
                            userId: user.id,
                            marker: newMarker
                        });
                    }

                    // Add a low opacity circle around the marker
                    const markerColor = user.status === 'ontravel' ? 'red' : '#3388ff';
                    L.circle([user.lat, user.lng], {
                        color: markerColor,
                        fillColor: markerColor,
                        opacity: 0.2, // Set outline opacity
                        fillOpacity: 0.2,
                        radius: 200 // Adjust radius as needed
                    }).addTo(view_map);
                });
            }

            function createMarker(view_map, user) {
                const initials = user.name.split(' ')
                    .map(word => word[0])
                    .join('');
                const markerColor = user.status === 'ontravel' ? 'red' : '#3388ff';

                const icon = L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div style="width: 45px; height: 45px; background-color: ${markerColor}; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; padding: 10px; border: 4px solid white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                ${initials}
                           </div>`,
                    iconSize: [45, 45]
                });

                const marker = L.marker([user.lat, user.lng], {
                    icon: icon
                }).addTo(view_map);

                marker.bindTooltip(user.name, {
                    permanent: false,
                    direction: 'top'
                });

                marker.bindPopup(`<b>${user.name}</b>`);

                return marker;
            }

            function animateMarker(marker, newLatLng) {
                const duration = 500; // Animation duration in ms
                const frames = 20; // Number of animation frames
                const interval = duration / frames;

                const startLatLng = marker.getLatLng();
                const deltaLat = (newLatLng[0] - startLatLng.lat) / frames;
                const deltaLng = (newLatLng[1] - startLatLng.lng) / frames;

                let frame = 0;

                const animation = setInterval(() => {
                    if (frame < frames) {
                        const lat = startLatLng.lat + deltaLat * frame;
                        const lng = startLatLng.lng + deltaLng * frame;
                        marker.setLatLng([lat, lng]);
                        frame++;
                    } else {
                        clearInterval(animation);
                        marker.setLatLng(newLatLng); // Ensure it ends at the exact location
                    }
                }, interval);
            }

            function searchMarkerByName(name) {
                const user = markerData.find(user => user.name.toLowerCase().trim().includes(name.toLowerCase().trim()));
                console.log(user);
                if (user) {
                    view_map.setView([user.lat, user.lng], 15);

                    const marker = markers.find(marker => marker.marker.getLatLng && marker.marker.getLatLng().lat === user
                        .lat && marker.marker.getLatLng().lng === user.lng);
                    if (marker) {
                        marker.marker.openTooltip();
                    }
                }
            }
        </script>
    @endpush
</div>
