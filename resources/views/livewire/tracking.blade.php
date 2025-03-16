<div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.select2-department').select2({
                    placeholder: "Filter by department",
                    allowClear: true
                });
                init_map();
            });

            const init_map = function() {
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
            }
        </script>
    @endpush
</div>
