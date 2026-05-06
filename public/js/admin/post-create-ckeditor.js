// ====================== CKEDITOR 5 ======================
let descriptionEditor;

const stripHtml = (html) => {
    const tmp = document.createElement('div');
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || '';
};

ClassicEditor.create(document.getElementById('description-editor'), {
    language: 'vi',
    placeholder: 'Mô tả chi tiết về phòng trọ, tiện ích xung quanh, điều kiện thuê...',
    toolbar: {
        items: [
            'heading', '|',
            'bold', 'italic', 'underline', 'strikethrough', '|',
            'bulletedList', 'numberedList', '|',
            'link', 'insertTable', '|',
            'undo', 'redo', 'sourceEditing'
        ]
    }
}).then(editor => {
    descriptionEditor = editor;
    const hidden = document.getElementById('description-hidden');

    if (hidden?.value) {
        editor.setData(hidden.value);
    }

    editor.model.document.on('change:data', () => {
        const data = editor.getData();
        if (hidden) hidden.value = data;
        const counter = document.getElementById('descCount');
        if (counter) counter.textContent = stripHtml(data).length;
    });

    const counter = document.getElementById('descCount');
    if (counter) counter.textContent = stripHtml(editor.getData()).length;
}).catch(console.error);

// ====================== TITLE COUNTER ======================
document.getElementById('title')?.addEventListener('input', function () {
    const counter = document.getElementById('titleCount');
    if (counter) counter.textContent = this.value.length;
});

// ====================== STEP NAVIGATION ======================
document.querySelectorAll('.step').forEach(step => {
    step.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
        this.classList.add('active');

        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            window.scrollTo({
                top: target.getBoundingClientRect().top + window.scrollY - 90,
                behavior: 'smooth'
            });
        }
    });
});

window.addEventListener('load', () => {
    document.querySelector('.step[href="#section-1"]')?.classList.add('active');
});

// ====================== DOM ======================
const provinceInput = document.getElementById('province');
const provinceIdInput = document.getElementById('province_id_input');

const wardInput = document.getElementById('ward');
const wardCodeInput = document.getElementById('ward_code_input');

const houseInput = document.getElementById('houseNumber');
const fullAddressDisplay = document.getElementById('fullAddressDisplay');
const fullAddressInput = document.getElementById('fullAddressInput');

const provinceOptions = Array.from(document.querySelectorAll('#province-list option')).map(opt => ({
    id: opt.getAttribute('data-id'),
    name: opt.value.trim()
}));

let wardOptions = [];
let selectedProvince = null;
let selectedWard = null;

// ====================== CUSTOM COMBOBOX ======================
function createComboBox(input, optionsGetter, onSelect, placeholderText = 'Tìm kiếm...') {
    if (!input) return null;

    const wrapper = document.createElement('div');
    wrapper.className = 'combo-wrapper';
    wrapper.style.position = 'relative';
    wrapper.style.width = '100%';

    input.parentNode.insertBefore(wrapper, input);
    wrapper.appendChild(input);

    const dropdown = document.createElement('div');
    dropdown.className = 'combo-dropdown';
    dropdown.style.position = 'absolute';
    dropdown.style.top = 'calc(100% + 4px)';
    dropdown.style.left = '0';
    dropdown.style.right = '0';
    dropdown.style.background = '#fff';
    dropdown.style.border = '1px solid #d1d3e2';
    dropdown.style.borderRadius = '8px';
    dropdown.style.boxShadow = '0 8px 24px rgba(0,0,0,.08)';
    dropdown.style.maxHeight = '240px';
    dropdown.style.overflowY = 'auto';
    dropdown.style.zIndex = '9999';
    dropdown.style.display = 'none';

    wrapper.appendChild(dropdown);

    const render = (keyword = '') => {
        const allOptions = optionsGetter() || [];
        const q = normalizeSearch(keyword);

        const filtered = !q
            ? allOptions
            : allOptions.filter(item => normalizeSearch(item.name).includes(q));

        dropdown.innerHTML = '';

        if (!filtered.length) {
            const empty = document.createElement('div');
            empty.textContent = 'Không có dữ liệu phù hợp';
            empty.style.padding = '10px 12px';
            empty.style.color = '#858796';
            empty.style.fontSize = '.9rem';
            dropdown.appendChild(empty);
            return;
        }

        filtered.forEach(item => {
            const option = document.createElement('div');
            option.className = 'combo-item';
            option.textContent = item.name;
            option.style.padding = '10px 12px';
            option.style.cursor = 'pointer';
            option.style.fontSize = '.95rem';

            option.addEventListener('mouseenter', () => {
                option.style.background = '#f8f9fc';
            });

            option.addEventListener('mouseleave', () => {
                option.style.background = '#fff';
            });

            option.addEventListener('click', () => {
                input.value = item.name;
                dropdown.style.display = 'none';
                onSelect(item);
            });

            dropdown.appendChild(option);
        });
    };

    const open = () => {
        render(input.value.trim());
        dropdown.style.display = 'block';
    };

    const close = () => {
        dropdown.style.display = 'none';
    };

    input.setAttribute('autocomplete', 'off');
    input.setAttribute('placeholder', placeholderText);

    input.addEventListener('focus', open);

    input.addEventListener('click', () => {
        open();
    });

    input.addEventListener('input', () => {
        render(input.value.trim());
        dropdown.style.display = 'block';
    });

    document.addEventListener('click', (e) => {
        if (!wrapper.contains(e.target)) {
            close();
        }
    });

    return {
        open,
        close,
        refresh: () => render(input.value.trim())
    };
}

function normalizeSearch(str) {
    return (str || '')
        .replace(/đ/g, 'd')
        .replace(/Đ/g, 'D')
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();
}

// ====================== MAP FILE CONFIG ======================
const provinceGeojsonMap = {
    'an giang': '/geojson/angiang_wards.geojson',
    'can tho': '/geojson/cantho_wards.geojson',
    'cần thơ': '/geojson/cantho_wards.geojson',
    'ha noi': '/geojson/hanoi_wards.geojson',
    'hà nội': '/geojson/hanoi_wards.geojson',
    'thanh pho ho chi minh': '/geojson/tphcm_wards.geojson',
    'thành phố hồ chí minh': '/geojson/tphcm_wards.geojson',
    'tp ho chi minh': '/geojson/tphcm_wards.geojson',
    'tp. ho chi minh': '/geojson/tphcm_wards.geojson',
    'tp hồ chí minh': '/geojson/tphcm_wards.geojson',
    'tp. hồ chí minh': '/geojson/tphcm_wards.geojson',
    'ho chi minh': '/geojson/tphcm_wards.geojson',
    'hồ chí minh': '/geojson/tphcm_wards.geojson'
};

// ====================== PROVINCE / WARD ======================
function resetProvince() {
    selectedProvince = null;
    provinceIdInput.value = '';
    provinceInput.value = '';
    resetWard();
    clearGeoLayer();
    updateAddress('', '');
}

function resetWard() {
    selectedWard = null;
    wardInput.value = '';
    wardInput.disabled = true;
    wardInput.placeholder = '-- Chọn tỉnh/thành trước --';
    wardCodeInput.value = '';
    wardOptions = [];
    updateAddress('', selectedProvince?.name || '');
}

function selectProvince(item) {
    selectedProvince = item;
    provinceIdInput.value = item.id || '';
    wardInput.disabled = false;
    wardInput.placeholder = '-- Tìm hoặc chọn phường/xã --';
    selectedWard = null;
    wardCodeInput.value = '';
    wardInput.value = '';
    wardOptions = [];
    updateAddress('', item.name);

    loadWards(item.id);
    loadProvinceGeoJson(item.name);
}

function selectWard(item) {
    selectedWard = item;
    wardCodeInput.value = item.id || '';
    updateAddress(item.name, selectedProvince?.name || '');
    highlightWardOnMap(item.name);
}

function loadWards(provinceId) {
    wardInput.disabled = true;
    wardInput.placeholder = 'Đang tải phường/xã...';
    wardInput.value = '';
    wardCodeInput.value = '';
    wardOptions = [];

    fetch('/user/wards/' + provinceId)
        .then(r => {
            if (!r.ok) {
                throw new Error('Không thể tải dữ liệu phường/xã');
            }
            return r.json();
        })
        .then(data => {
            wardOptions = (data || []).map(w => ({
                id: w.id,
                name: w.name
            }));

            wardInput.disabled = false;
            wardInput.placeholder = '-- Tìm hoặc chọn phường/xã --';
            wardCombo?.refresh();
        })
        .catch((error) => {
            console.error(error);
            wardInput.disabled = true;
            wardInput.placeholder = 'Lỗi tải dữ liệu phường/xã';
        });
}

const provinceCombo = createComboBox(
    provinceInput,
    () => provinceOptions,
    selectProvince,
    '-- Tìm hoặc chọn tỉnh/thành --'
);

const wardCombo = createComboBox(
    wardInput,
    () => wardOptions,
    selectWard,
    '-- Chọn tỉnh/thành trước --'
);

// Nếu user gõ tay rồi blur mà không chọn item hợp lệ
provinceInput.addEventListener('blur', () => {
    setTimeout(() => {
        const found = provinceOptions.find(
            p => normalizeSearch(p.name) === normalizeSearch(provinceInput.value)
        );

        if (!found) {
            resetProvince();
        }
    }, 150);
});

wardInput.addEventListener('blur', () => {
    setTimeout(() => {
        const found = wardOptions.find(
            w => normalizeSearch(w.name) === normalizeSearch(wardInput.value)
        );

        if (!found) {
            selectedWard = null;
            wardCodeInput.value = '';
            wardInput.value = '';
            updateAddress('', selectedProvince?.name || '');
            resetWardStyle();
        }
    }, 150);
});

// ====================== ĐỊA CHỈ ĐẦY ĐỦ ======================
function updateAddress(wardName, provinceName) {
    const house = houseInput?.value.trim() || '';
    const full = [house, wardName, provinceName].filter(Boolean).join(', ');

    if (fullAddressDisplay) {
        fullAddressDisplay.textContent = full || '-- Chọn tỉnh/thành và phường/xã --';
    }

    if (fullAddressInput) {
        fullAddressInput.value = full;
    }
}

houseInput?.addEventListener('input', function () {
    updateAddress(selectedWard?.name || '', selectedProvince?.name || '');
});

// ====================== LEAFLET MAP ======================
const map = L.map('map').setView([10.5216, 105.1259], 10);

const googleStreet = L.tileLayer(
    'https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',
    { attribution: '© Google Maps', maxZoom: 20 }
);

const googleSatellite = L.tileLayer(
    'https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',
    { attribution: '© Google Maps', maxZoom: 20 }
);

const googleHybrid = L.tileLayer(
    'https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}',
    { attribution: '© Google Maps', maxZoom: 20 }
);

googleStreet.addTo(map);

L.control.layers({
    '🗺 Bản đồ': googleStreet,
    '🛰 Vệ tinh': googleSatellite,
    '🛰 Vệ tinh + tên': googleHybrid
}, null, { position: 'topright' }).addTo(map);

let geoLayer = null;
let pinMarker = null;

function clearGeoLayer() {
    if (geoLayer) {
        map.removeLayer(geoLayer);
        geoLayer = null;
    }
}

function loadProvinceGeoJson(provinceName) {
    const key = normalizeSearch(provinceName);
    const file = provinceGeojsonMap[key];

    clearGeoLayer();

    if (!file) return;

    fetch(file)
        .then(r => r.json())
        .then(data => {
            geoLayer = L.geoJSON(data, {
                style: {
                    color: '#aaaaaa',
                    weight: 1,
                    fillOpacity: 0,
                    opacity: 0.5
                },
                onEachFeature(feature, layer) {
                    layer.bindPopup(feature.properties.ten_xa || '');

                    layer.on('click', (e) => {
                        L.DomEvent.stopPropagation(e);
                        map.fire('click', { latlng: e.latlng });
                    });
                }
            }).addTo(map);

            if (geoLayer.getBounds().isValid()) {
                map.fitBounds(geoLayer.getBounds(), { padding: [20, 20] });
            }
        })
        .catch(err => {
            console.error('Lỗi tải GeoJSON:', err);
        });
}

// Click map — reverse geocode + pin
map.on('click', function (e) {
    const { lat, lng } = e.latlng;

    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&accept-language=vi`)
        .then(r => r.json())
        .then(data => {
            const popup = buildPopup(data.display_name || 'Không xác định', lat, lng);

            if (pinMarker) {
                pinMarker.setLatLng(e.latlng).setPopupContent(popup).openPopup();
            } else {
                pinMarker = L.marker(e.latlng, { draggable: true })
                    .addTo(map)
                    .bindPopup(popup)
                    .openPopup();

                pinMarker.on('dragend', () => saveLatLng(pinMarker.getLatLng()));
            }

            saveLatLng({ lat, lng });
        })
        .catch(console.error);
});

// Zoom + pin khi nhập số nhà
houseInput?.addEventListener('input', debounce(function () {
    const house = this.value.trim();
    const wardName = selectedWard?.name || '';
    const provinceName = selectedProvince?.name || '';

    if (!house || !wardName || !provinceName) return;

    const query = `${house}, ${wardName}, ${provinceName}, Vietnam`;

    fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=1&accept-language=vi`)
        .then(r => r.json())
        .then(data => {
            if (!data.length) return;

            const { lat, lon, display_name } = data[0];
            map.setView([lat, lon], 17);

            const popup = buildPopup(display_name, lat, lon);

            if (pinMarker) {
                pinMarker.setLatLng([lat, lon]).setPopupContent(popup).openPopup();
            } else {
                pinMarker = L.marker([lat, lon], { draggable: true })
                    .addTo(map)
                    .bindPopup(popup)
                    .openPopup();

                pinMarker.on('dragend', () => saveLatLng(pinMarker.getLatLng()));
            }

            saveLatLng({ lat, lng: lon });
        })
        .catch(console.error);
}, 800));

// ====================== HIGHLIGHT WARD ======================
function highlightWardOnMap(wardName) {
    if (!geoLayer) return;

    const norm = normalizeName(wardName);
    let matchedLayer = null;

    geoLayer.eachLayer(layer => {
        const featureName = layer.feature?.properties?.ten_xa || '';
        const isMatch = normalizeName(featureName) === norm;

        layer.setStyle(isMatch
            ? {
                color: '#4e73df',
                weight: 2.5,
                fillColor: '#4e73df',
                fillOpacity: 0.3,
                opacity: 1
            }
            : {
                color: '#aaaaaa',
                weight: 1,
                fillOpacity: 0,
                opacity: 0.15
            }
        );

        if (isMatch) {
            matchedLayer = layer;
        }
    });

    if (matchedLayer) {
        map.fitBounds(matchedLayer.getBounds(), { padding: [20, 20] });
        matchedLayer.openPopup();
    }
}

function resetWardStyle() {
    if (!geoLayer) return;

    geoLayer.eachLayer(layer => {
        layer.setStyle({
            color: '#aaaaaa',
            weight: 1,
            fillOpacity: 0,
            opacity: 0.5
        });
    });
}

// ====================== HELPERS ======================
function saveLatLng({ lat, lng }) {
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    if (latInput) latInput.value = parseFloat(lat).toFixed(7);
    if (lngInput) lngInput.value = parseFloat(lng).toFixed(7);
}

function buildPopup(name, lat, lng) {
    return `
        <div style="font-family:'Nunito',sans-serif;font-size:.8rem;line-height:1.6">
            <div style="font-weight:700;color:#4e73df;margin-bottom:.3rem">
                <i class="fas fa-map-marker-alt"></i> Vị trí đã chọn
            </div>
            <div style="color:#5a5c69">${name}</div>
            <div style="margin-top:.4rem;color:#858796;font-size:.75rem">
                📍 ${parseFloat(lat).toFixed(6)}, ${parseFloat(lng).toFixed(6)}
            </div>
        </div>
    `;
}

function normalizeName(str) {
    if (!str) return '';
    return str
        .replace(/đ/g, 'd')
        .replace(/Đ/g, 'D')
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/^(xa|phuong|thi ?tran|thi ?xa|quan)\s*/i, '')
        .replace(/\s+/g, '')
        .trim();
}

function debounce(fn, delay) {
    let t;
    return function (...args) {
        clearTimeout(t);
        t = setTimeout(() => fn.apply(this, args), delay);
    };
}

// ====================== IMAGE UPLOAD ======================
const imgInput = document.getElementById('imgInput');
const previewGrid = document.getElementById('previewGrid');
const uploadZone = document.getElementById('uploadZone');

let selectedFiles = [];

imgInput?.addEventListener('change', function () {
    handleFiles(Array.from(this.files));
});

uploadZone?.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadZone.classList.add('dragging');
});

uploadZone?.addEventListener('dragleave', () => {
    uploadZone.classList.remove('dragging');
});

uploadZone?.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadZone.classList.remove('dragging');
    const files = Array.from(e.dataTransfer.files).filter(f => f.type.match('image.*'));
    handleFiles(files);
});

function handleFiles(newFiles) {
    const MAX = 20;
    const MAX_SIZE = 10 * 1024 * 1024;

    newFiles.forEach(file => {
        if (selectedFiles.length >= MAX) return;
        if (!file.type.match('image/(jpeg|png|webp)')) return;

        if (file.size > MAX_SIZE) {
            alert(`Ảnh "${file.name}" vượt quá 10MB`);
            return;
        }

        selectedFiles.push(file);
        renderPreview(file, selectedFiles.length - 1);
    });

    syncInput();
}

function renderPreview(file, index) {
    const reader = new FileReader();

    reader.onload = (e) => {
        const item = document.createElement('div');
        item.className = 'img-preview-item';
        item.dataset.index = index;
        item.innerHTML = `
            <img src="${e.target.result}" alt="preview">
            <button type="button" class="remove-btn" onclick="removeImage(${index})">&times;</button>
        `;
        previewGrid?.appendChild(item);
    };

    reader.readAsDataURL(file);
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    if (previewGrid) previewGrid.innerHTML = '';
    selectedFiles.forEach((file, i) => renderPreview(file, i));
    syncInput();
}

function syncInput() {
    if (!imgInput) return;

    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    imgInput.files = dt.files;
}

window.removeImage = removeImage;