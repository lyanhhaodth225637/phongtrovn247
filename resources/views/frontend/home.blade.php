<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <style>
        .ts-control {
            border-radius: 6px;
        }

        .ts-dropdown {
            z-index: 1000;
        }
    </style>
</head>

<body>

    <div>
        @auth
            <h1>{{ auth()->user()->name }}</h1>
            <img id="avatarPreview" width="200px" src="{{ asset('storage/' . (auth()->user()->avatar ?? 'default/avt_default.png')) }}" alt="Avatar">
        @endauth
    </div>

    <h3>Chọn khu vực</h3>

    <select id="province">
        <option value="">-- Chọn tỉnh --</option>
        @foreach($provinces as $province)
            <option value="{{ $province->id }}">{{ $province->name }}</option>
        @endforeach
    </select>

    <select id="ward">
        <option value="">-- Chọn phường/xã --</option>
    </select>

    <br><br>

    <div id="map" style="height:600px"></div>

    <script>

        /* ── Tom Select khởi tạo ── */

        const tsProvince = new TomSelect('#province', {
            placeholder: '-- Tìm hoặc chọn tỉnh --',
            allowEmptyOption: true
        });

        let tsWard = new TomSelect('#ward', {
            placeholder: '-- Tìm hoặc chọn phường/xã --',
            allowEmptyOption: true
        });


        /* ── Leaflet map ── */

        var map = L.map('map').setView([10.52, 105.12], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let geoLayer = null;


        /* load geojson */
        fetch('/geojson/angiang_wards.geojson')
            .then(res => res.json())
            .then(data => {

                geoLayer = L.geoJSON(data, {
                    style: { color: "#ff0000", weight: 1, fillOpacity: 0.1 },
                    onEachFeature: function (feature, layer) {
                        layer.bindPopup(feature.properties.ten_xa || '');
                    }
                }).addTo(map);

            });


        /* load ward theo province */

        tsProvince.on('change', function (provinceId) {

            if (!provinceId) return;

            fetch('/wards/' + provinceId)
                .then(res => res.json())
                .then(data => {

                    // Xóa options cũ và destroy để tạo lại
                    tsWard.destroy();

                    const wardSelect = document.getElementById('ward');
                    wardSelect.innerHTML = "<option value=''>-- Chọn phường/xã --</option>";

                    data.forEach(ward => {
                        wardSelect.innerHTML +=
                            `<option value="${ward.code}" data-name="${ward.name}">${ward.name}</option>`;
                    });

                    // Khởi tạo lại Tom Select
                    tsWard = new TomSelect('#ward', {
                        placeholder: '-- Tìm hoặc chọn phường/xã --',
                        allowEmptyOption: true
                    });

                    tsWard.on('change', handleWardChange);

                });

        });


        /* highlight ward trên map */

        function handleWardChange(wardCode) {

            if (!wardCode || !geoLayer) return;

            const selectedOption = document.querySelector(`#ward option[value="${wardCode}"]`);
            if (!selectedOption) return;

            const wardName = selectedOption.getAttribute('data-name');
            const wardNameNorm = normalizeName(wardName);

            geoLayer.eachLayer(function (layer) {

                const geoName = normalizeName(layer.feature.properties.ten_xa || '');

                if (geoName === wardNameNorm) {
                    layer.setStyle({ color: "blue", weight: 3, fillOpacity: 0.3 });
                    map.fitBounds(layer.getBounds());
                    layer.openPopup();
                } else {
                    layer.setStyle({ color: "#ff0000", weight: 1, fillOpacity: 0.1 });
                }

            });

        }

        tsWard.on('change', handleWardChange);


        /* normalize name */

        function normalizeName(str) {
            if (!str) return '';
            return str
                .replace(/đ/g, 'd').replace(/Đ/g, 'D')
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/^(xa|phuong|thi ?tran|thi ?xa|quan)\s*/i, '')
                .replace(/\s+/g, '')
                .trim();
        }

    </script>

</body>

</html>