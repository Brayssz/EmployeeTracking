<div>
    @push('scripts')
        <script>

            let view_map;
            let markers = [];
            let markerData = [];

            $(document).ready(function() {
                initializeSelect2();
                getTravelAttendanceLoc(1);
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

                    getTravelAttendanceLoc(travelId)
                        if (markerData.length > 0) {
                        const firstUser = markerData[0];
                        view_map.setView([firstUser.lat, firstUser.lng], 15);
                    }
                
                } else {
                    getTravelAttendanceLoc(null);
                }
            });

            $('.search-employee').on('keyup ', function() {
                const searchValue = $(this).val();

                if (searchValue.length > 0) {
                    searchMarkerByName(searchValue);
                } 
            });

            function getTravelAttendanceLoc(travel_id) {
                @this.call('getTravelAttendance', travel_id).then(response => {
                    console.log(response);

                    initMarkers(view_map, response);

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

            function initMarkers(view_map, users = []) {
                markers.forEach(marker => {
                    view_map.removeLayer(marker);
                });
                markers = [];
                markerData = users;

                users.forEach(user => {
                    const initials = user.name.split(' ').map(word => word[0]).join('');
                    const marker = L.circleMarker([user.lat, user.lng], {
                        radius: 20,
                        color: '#3388ff',
                        fillColor: '#3388ff',
                        fillOpacity: 0.7
                    }).addTo(view_map);

                    marker.bindTooltip(user.name, { permanent: false, direction: 'top' });
                    marker.bindPopup(`<b>${user.name}</b>`);

                    const icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style="width: 25px; height:25px; background-color: #3388ff; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">${initials}</div>`,
                        iconSize: [25, 25]
                    });

                    const customMarker = L.marker([user.lat, user.lng], { icon: icon }).addTo(view_map);
                    markers.push(marker);
                    markers.push(customMarker);
                });
            }

            function searchMarkerByName(name) {
                const user = markerData.find(user => user.name.toLowerCase().trim().includes(name.toLowerCase().trim()));
                console.log(user);
                if (user) {
                    view_map.setView([user.lat, user.lng], 15);

                    const marker = markers.find(marker => marker.getLatLng && marker.getLatLng().lat === user.lat && marker.getLatLng().lng === user.lng);
                    if (marker) {
                        marker.openTooltip();
                    }
                } 
            }
        </script>
    @endpush
</div>
