// ====================== CKEDITOR 5 ======================
let descriptionEditor;

const stripHtml = html => {
    const tmp = document.createElement('div');
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || '';
};

ClassicEditor.create(document.getElementById('description-editor'), {
    language: 'vi',
    placeholder: 'Mô tả chi tiết về phòng trọ, tiện ích xung quanh, điều kiện thuê...',
    toolbar: { items: ['heading','|','bold','italic','underline','strikethrough','|','bulletedList','numberedList','|','link','insertTable','|','undo','redo','sourceEditing'] }
}).then(editor => {
    descriptionEditor = editor;
    const hidden = document.getElementById('description-hidden');
    if (hidden?.value) editor.setData(hidden.value);
    editor.model.document.on('change:data', () => {
        const data = editor.getData();
        if (hidden) hidden.value = data;
        document.getElementById('descCount').textContent = stripHtml(data).length;
    });
    document.getElementById('descCount').textContent = stripHtml(editor.getData()).length;
}).catch(console.error);

// ====================== TITLE COUNTER ======================
document.getElementById('title')?.addEventListener('input', function () {
    document.getElementById('titleCount').textContent = this.value.length;
});

// ====================== STEP NAVIGATION ======================
document.querySelectorAll('.step').forEach(step => {
    step.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
        this.classList.add('active');
        const target = document.querySelector(this.getAttribute('href'));
        if (target) window.scrollTo({ top: target.getBoundingClientRect().top + window.scrollY - 90, behavior: 'smooth' });
    });
});

window.addEventListener('load', () => {
    document.querySelector('.step[href="#section-1"]')?.classList.add('active');
});

// ====================== PROVINCE / WARD ======================
const provinceMap = {};
document.querySelectorAll('#province-list option').forEach(opt => {
    provinceMap[opt.value.trim().toLowerCase()] = opt.getAttribute('data-id');
});

const provinceInput   = document.getElementById('province');
const provinceIdInput = document.getElementById('province_id_input');
const wardInput       = document.getElementById('ward');
const wardCodeInput   = document.getElementById('ward_code_input');
const wardList        = document.getElementById('ward-list');

provinceInput.addEventListener('input', function () {
    const id = provinceMap[this.value.trim().toLowerCase()];
    provinceIdInput.value = id || '';
    id ? loadWards(id, this.value.trim()) : resetWard();
});

function loadWards(provinceId, provinceName) {
    Object.assign(wardInput, { disabled: true, placeholder: 'Đang tải...', value: '' });
    wardList.innerHTML = '';
    wardCodeInput.value = '';

    fetch('/admin/wards/' + provinceId)
        .then(r => r.json())
        .then(data => {
            wardInput._wardMap = {};
            wardList.innerHTML = '';
            data.forEach(w => {
            wardInput._wardMap[w.name.trim().toLowerCase()] = { 
                id: w.id,   // 🔥 đổi từ code → id
                name: w.name 
            };
                const opt = document.createElement('option');
                opt.value = w.name;
                wardList.appendChild(opt);
            });
            wardInput._provinceName = provinceName;
            Object.assign(wardInput, { disabled: false, placeholder: '-- Tìm hoặc chọn phường/xã --' });
            updateAddress('', provinceName);
        })
        .catch(() => { wardInput.placeholder = 'Lỗi tải dữ liệu'; });
}

function resetWard() {
    Object.assign(wardInput, { disabled: true, value: '', placeholder: '-- Chọn tỉnh/thành trước --' });
    wardList.innerHTML = '';
    wardCodeInput.value = '';
    updateAddress('', '');
}

wardInput.addEventListener('input', function () {
    const ward = (this._wardMap || {})[this.value.trim().toLowerCase()];
    wardCodeInput.value = ward?.id || '';
    if (ward) {
        updateAddress(ward.name, this._provinceName || '');
        highlightWardOnMap(ward.name);
    }
});

// ====================== ĐỊA CHỈ ĐẦY ĐỦ ======================
function updateAddress(wardName, provinceName) {
    const house = document.getElementById('houseNumber').value.trim();
    const full  = [house, wardName, provinceName].filter(Boolean).join(', ');
    document.getElementById('fullAddressDisplay').textContent = full || '-- Chọn tỉnh/thành và phường/xã --';
    document.getElementById('fullAddressInput').value = full;
}

document.getElementById('houseNumber').addEventListener('input', function () {
    const ward = (wardInput._wardMap || {})[wardInput.value.trim().toLowerCase()];
    updateAddress(ward?.name || '', wardInput._provinceName || '');
});

// ====================== LEAFLET MAP ======================
const map = L.map('map').setView([10.5216, 105.1259], 10);

const googleStreet    = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', { attribution: '© Google Maps', maxZoom: 20 });
const googleSatellite = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', { attribution: '© Google Maps', maxZoom: 20 });
const googleHybrid    = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { attribution: '© Google Maps', maxZoom: 20 });

googleStreet.addTo(map);
L.control.layers({ '🗺 Bản đồ': googleStreet, '🛰 Vệ tinh': googleSatellite, '🛰 Vệ tinh + tên': googleHybrid }, null, { position: 'topright' }).addTo(map);

let geoLayer = null, pinMarker = null;

fetch('/geojson/angiang_wards.geojson')
    .then(r => r.json())
    .then(data => {
        geoLayer = L.geoJSON(data, {
            style: { color: '#aaaaaa', weight: 1, fillOpacity: 0, opacity: 0.5 },
            onEachFeature(feature, layer) {
                layer.bindPopup(feature.properties.ten_xa || '');
                layer.on('click', e => {
                    L.DomEvent.stopPropagation(e);
                    map.fire('click', { latlng: e.latlng });
                });
            }
        }).addTo(map);
    });

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
                pinMarker = L.marker(e.latlng, { draggable: true }).addTo(map).bindPopup(popup).openPopup();
                pinMarker.on('dragend', () => saveLatLng(pinMarker.getLatLng()));
            }
            saveLatLng({ lat, lng });
        });
});

// Zoom + pin khi nhập số nhà
document.getElementById('houseNumber').addEventListener('input', debounce(function () {
    const house    = this.value.trim();
    const wardName = wardInput.value.trim();
    const province = wardInput._provinceName || '';
    if (!house || !wardName) return;

    fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(`${house}, ${wardName}, ${province}, Vietnam`)}&format=json&limit=1&accept-language=vi`)
        .then(r => r.json())
        .then(data => {
            if (!data.length) return;
            const { lat, lon, display_name } = data[0];
            map.setView([lat, lon], 17);
            const popup = buildPopup(display_name, lat, lon);
            if (pinMarker) {
                pinMarker.setLatLng([lat, lon]).setPopupContent(popup).openPopup();
            } else {
                pinMarker = L.marker([lat, lon], { draggable: true }).addTo(map).bindPopup(popup).openPopup();
                pinMarker.on('dragend', () => saveLatLng(pinMarker.getLatLng()));
            }
            saveLatLng({ lat, lng: lon });
        });
}, 800));

// ====================== HIGHLIGHT WARD ======================
function highlightWardOnMap(wardName) {
    if (!geoLayer) return;
    const norm = normalizeName(wardName);
    geoLayer.eachLayer(layer => {
        const match = normalizeName(layer.feature.properties.ten_xa || '') === norm;
        layer.setStyle(match
            ? { color: '#4e73df', weight: 2.5, fillColor: '#4e73df', fillOpacity: 0.3 }
            : { color: '#aaaaaa', weight: 1, fillOpacity: 0, opacity: 0.1 }
        );
        if (match) { map.fitBounds(layer.getBounds()); layer.openPopup(); }
    });
}

// ====================== HELPERS ======================
function saveLatLng({ lat, lng }) {
    document.getElementById('latitude').value  = parseFloat(lat).toFixed(7);
    document.getElementById('longitude').value = parseFloat(lng).toFixed(7);
}

function buildPopup(name, lat, lng) {
    return `<div style="font-family:'Nunito',sans-serif;font-size:.8rem;line-height:1.6">
        <div style="font-weight:700;color:#4e73df;margin-bottom:.3rem"><i class="fas fa-map-marker-alt"></i> Vị trí đã chọn</div>
        <div style="color:#5a5c69">${name}</div>
        <div style="margin-top:.4rem;color:#858796;font-size:.75rem">📍 ${parseFloat(lat).toFixed(6)}, ${parseFloat(lng).toFixed(6)}</div>
    </div>`;
}

function normalizeName(str) {
    if (!str) return '';
    return str.replace(/đ/g,'d').replace(/Đ/g,'D')
        .toLowerCase().normalize('NFD')
        .replace(/[\u0300-\u036f]/g,'')
        .replace(/^(xa|phuong|thi ?tran|thi ?xa|quan)\s*/i,'')
        .replace(/\s+/g,'').trim();
}

function debounce(fn, delay) {
    let t;
    return function (...args) { clearTimeout(t); t = setTimeout(() => fn.apply(this, args), delay); };
}

const imgInput = document.getElementById('imgInput');
const previewGrid = document.getElementById('previewGrid');
const uploadZone = document.getElementById('uploadZone');

let selectedFiles = [];

// Chọn ảnh qua input
imgInput.addEventListener('change', function () {
    handleFiles(Array.from(this.files));
});

// Drag & Drop
uploadZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadZone.classList.add('dragging');
});

uploadZone.addEventListener('dragleave', () => {
    uploadZone.classList.remove('dragging');
});

uploadZone.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadZone.classList.remove('dragging');
    const files = Array.from(e.dataTransfer.files).filter(f => f.type.match('image.*'));
    handleFiles(files);
});

function handleFiles(newFiles) {
    const MAX = 20;
    const MAX_SIZE = 10 * 1024 * 1024; // 10MB

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
        previewGrid.appendChild(item);
    };
    reader.readAsDataURL(file);
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    previewGrid.innerHTML = '';
    selectedFiles.forEach((file, i) => renderPreview(file, i));
    syncInput();
}

function syncInput() {
    // Tạo lại DataTransfer để gán files vào input
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    imgInput.files = dt.files;
}