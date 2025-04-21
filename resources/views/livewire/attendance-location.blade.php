<div>
    @push('scripts')
        <script>
            let view_map;
            let markers = [];
            let markerData = [];

            let travelUserId;

            $(document).ready(function() {
                initializeSelect2();
            });

            function initializeSelect2() {
                $('.select2-department').select2({
                    placeholder: "Filter by department",
                    allowClear: true
                });
            }

            $(document).on('click', '.view-location', function() {
                travelUserId = $(this).data('traveluserid');

                const status = $(this).data('status');
                if (status === 'pending') {
                    Swal.fire({
                        icon: 'info',
                        title: 'No Attendance Recorded',
                        text: 'No attendance recorded yet.',
                    });
                    return;
                }
                $('#show-location-modal').modal('show');
            });

            function getTravelAttendanceLoc(travel_id) {

                @this.call('getTravelAttendance', travel_id).then(response => {
                    console.log(response);

                    initMarkers(view_map, response);
                });
            }

            $('#show-location-modal').on('shown.bs.modal', function() {
                if (!view_map) {
                    view_map = initMap();
                    getTravelAttendanceLoc(travelUserId);
                } else {
                    view_map = initMap();
                    getTravelAttendanceLoc(travelUserId);
                }
            });


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

                    marker.bindTooltip(user.name, {
                        permanent: false,
                        direction: 'top'
                    });
                    marker.bindPopup(`<b>${user.name}</b>`);

                    const icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style="width: 25px; height:25px; background-color: #3388ff; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">${initials}</div>`,
                        iconSize: [25, 25]
                    });

                    const customMarker = L.marker([user.lat, user.lng], {
                        icon: icon
                    }).addTo(view_map);
                    markers.push(marker);
                    markers.push(customMarker);
                });
                const firstUser = markerData[0];
                view_map.setView([firstUser.lat, firstUser.lng], 15);
            }

            function initMap() {
                const view_map = L.map('view_map').setView([6.497396, 124.847160], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(view_map);

                return view_map;
            }
        </script>
    @endpush
</div>
