document.addEventListener('DOMContentLoaded', function () {

    // ====================== HELPERS ======================
    function debounce(fn, delay) {
        let t;
        return function (...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    function stripHtml(html) {
        const tmp = document.createElement('div');
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || '';
    }

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


    // ====================== CKEDITOR 5 ======================
    const editorEl = document.getElementById('description-editor');
    if (editorEl && typeof ClassicEditor !== 'undefined') {
        ClassicEditor.create(editorEl, {
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
            window.descriptionEditor = editor;

            const hidden   = document.getElementById('description-hidden');
            const descCount = document.getElementById('descCount');

            // Nếu có dữ liệu cũ (old input) thì set vào editor
            if (hidden?.value) editor.setData(hidden.value);

            editor.model.document.on('change:data', () => {
                const data = editor.getData();
                if (hidden)    hidden.value    = data;
                if (descCount) descCount.textContent = stripHtml(data).length;
            });

            if (descCount) descCount.textContent = stripHtml(editor.getData()).length;
        }).catch(err => console.error('CKEditor lỗi:', err));
    }


    // ====================== TITLE COUNTER ======================
    const titleInput = document.getElementById('title');
    const titleCount = document.getElementById('titleCount');
    if (titleInput && titleCount) {
        titleCount.textContent = titleInput.value.length;
        titleInput.addEventListener('input', function () {
            titleCount.textContent = this.value.length;
        });
    }


    // ====================== STEP NAVIGATION ======================
    const steps = document.querySelectorAll('.step');
    if (steps.length) {
        steps.forEach(step => {
            step.addEventListener('click', function (e) {
                e.preventDefault();
                steps.forEach(s => s.classList.remove('active'));
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

        // Highlight step active khi scroll
        window.addEventListener('scroll', debounce(function () {
            const sectionIds = ['section-1', 'section-2', 'section-3', 'section-4', 'section-5', 'section-6'];
            let current = sectionIds[0];
            sectionIds.forEach(id => {
                const el = document.getElementById(id);
                if (el && el.getBoundingClientRect().top <= 120) current = id;
            });
            steps.forEach(s => {
                s.classList.toggle('active', s.getAttribute('href') === '#' + current);
            });
        }, 100));

        // Active step đầu tiên khi load
        document.querySelector('.step[href="#section-1"]')?.classList.add('active');
    }


    // ====================== PROVINCE / WARD ======================
    const provinceInput   = document.getElementById('province');
    const provinceIdInput = document.getElementById('province_id_input');
    const wardInput       = document.getElementById('ward');
    const wardCodeInput   = document.getElementById('ward_code_input');
    const wardList        = document.getElementById('ward-list');

    if (!provinceInput) return; // Trang không có form địa chỉ thì dừng

    // Build map tên tỉnh → id từ datalist
    const provinceMap = {};
    document.querySelectorAll('#province-list option').forEach(opt => {
        provinceMap[opt.value.trim().toLowerCase()] = opt.getAttribute('data-id');
    });

    ['input', 'change', 'blur'].forEach(evt => {
        provinceInput.addEventListener(evt, function () {
            tryLoadWard(this.value.trim());
        });
    });

    function tryLoadWard(value) {
        const id = provinceMap[value.toLowerCase()];
        provinceIdInput.value = id || '';
        if (id) {
            loadWards(id, value);
        } else {
            resetWard();
        }
    }

    function loadWards(provinceId, provinceName) {
        wardInput.disabled    = true;
        wardInput.placeholder = 'Đang tải...';
        wardInput.value       = '';
        wardList.innerHTML    = '';
        wardCodeInput.value   = '';

        fetch('/user/wards/' + provinceId)
            .then(r => {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            })
            .then(data => {
                wardInput._wardMap  = {};
                wardList.innerHTML  = '';

                data.forEach(w => {
                    wardInput._wardMap[w.name.trim().toLowerCase()] = { id: w.id, name: w.name };
                    const opt = document.createElement('option');
                    opt.value = w.name;
                    wardList.appendChild(opt);
                });

                wardInput._provinceName = provinceName;
                wardInput.disabled      = false;
                wardInput.placeholder   = '-- Tìm hoặc chọn phường/xã --';
                updateAddress('', provinceName);
            })
            .catch(err => {
                console.error('Load ward lỗi:', err);
                wardInput.placeholder = 'Lỗi tải dữ liệu';
                wardInput.disabled    = false;
            });
    }

    function resetWard() {
        wardInput.disabled    = true;
        wardInput.value       = '';
        wardInput.placeholder = '-- Chọn tỉnh/thành trước --';
        wardList.innerHTML    = '';
        wardCodeInput.value   = '';
        updateAddress('', '');
    }

    ['input', 'change', 'blur'].forEach(evt => {
        wardInput.addEventListener(evt, function () {
            const ward = (this._wardMap || {})[this.value.trim().toLowerCase()];
            wardCodeInput.value = ward?.id || '';
            if (ward) {
                updateAddress(ward.name, this._provinceName || '');
                highlightWardOnMap(ward.name);
            }
        });
    });


    // ====================== ĐỊA CHỈ ĐẦY ĐỦ ======================
    const houseNumberInput    = document.getElementById('houseNumber');
    const fullAddressDisplay  = document.getElementById('fullAddressDisplay');
    const fullAddressInput    = document.getElementById('fullAddressInput');

    function updateAddress(wardName, provinceName) {
        const house = houseNumberInput?.value.trim() || '';
        const full  = [house, wardName, provinceName].filter(Boolean).join(', ');
        if (fullAddressDisplay) fullAddressDisplay.textContent = full || '-- Chọn tỉnh/thành và phường/xã --';
        if (fullAddressInput)   fullAddressInput.value         = full;
    }

    houseNumberInput?.addEventListener('input', function () {
        const ward = (wardInput._wardMap || {})[wardInput.value.trim().toLowerCase()];
        updateAddress(ward?.name || '', wardInput._provinceName || '');
    });


    // ====================== LEAFLET MAP ======================
    const mapEl = document.getElementById('map');
    if (!mapEl) return;

    if (typeof L === 'undefined') {
        console.error('Leaflet chưa được load!');
        return;
    }

    const map = L.map('map').setView([10.5216, 105.1259], 10);

    const googleStreet    = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', { attribution: '© Google Maps', maxZoom: 20 });
    const googleSatellite = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', { attribution: '© Google Maps', maxZoom: 20 });
    const googleHybrid    = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { attribution: '© Google Maps', maxZoom: 20 });

    googleStreet.addTo(map);
    // L.control.layers(
    //     { '🗺 Bản đồ': googleStreet, '🛰 Vệ tinh': googleSatellite, '🛰 Vệ tinh + tên': googleHybrid },
    //     null,
    //     { position: 'topright' }
    // ).addTo(map);

    let geoLayer = null, pinMarker = null;

    // Load GeoJSON
    fetch('/geojson/angiang_wards.geojson')
        .then(r => {
            if (!r.ok) throw new Error('GeoJSON không tìm thấy');
            return r.json();
        })
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
        })
        .catch(err => console.warn('GeoJSON:', err.message));

    // Click map → reverse geocode + đặt pin
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
            .catch(err => console.error('Reverse geocode lỗi:', err));
    });

    // Zoom + đặt pin khi nhập số nhà
    houseNumberInput?.addEventListener('input', debounce(function () {
        const house    = this.value.trim();
        const wardName = wardInput.value.trim();
        const province = wardInput._provinceName || '';
        if (!house || !wardName) return;

        fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(`${house}, ${wardName}, ${province}, Vietnam`)}&format=json&limit=1&accept-language=vi`)
            .then(r => r.json())
            .then(data => {
                if (!data.length) return;
                const { lat, lon, display_name } = data[0];
                map.setView([+lat, +lon], 17);
                const popup = buildPopup(display_name, lat, lon);
                if (pinMarker) {
                    pinMarker.setLatLng([+lat, +lon]).setPopupContent(popup).openPopup();
                } else {
                    pinMarker = L.marker([+lat, +lon], { draggable: true })
                        .addTo(map)
                        .bindPopup(popup)
                        .openPopup();
                    pinMarker.on('dragend', () => saveLatLng(pinMarker.getLatLng()));
                }
                saveLatLng({ lat, lng: lon });
            })
            .catch(err => console.error('Geocode lỗi:', err));
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
            if (match) {
                map.fitBounds(layer.getBounds());
                layer.openPopup();
            }
        });
    }


    // ====================== HELPERS MAP ======================
    function saveLatLng({ lat, lng }) {
        const latEl = document.getElementById('latitude');
        const lngEl = document.getElementById('longitude');
        if (latEl) latEl.value = parseFloat(lat).toFixed(7);
        if (lngEl) lngEl.value = parseFloat(lng).toFixed(7);
    }

    function buildPopup(name, lat, lng) {
        return `<div style="font-family:'Nunito',sans-serif;font-size:.8rem;line-height:1.6">
            <div style="font-weight:700;color:#4e73df;margin-bottom:.3rem">
                <i class="fas fa-map-marker-alt"></i> Vị trí đã chọn
            </div>
            <div style="color:#5a5c69">${name}</div>
            <div style="margin-top:.4rem;color:#858796;font-size:.75rem">
                📍 ${parseFloat(lat).toFixed(6)}, ${parseFloat(lng).toFixed(6)}
            </div>
        </div>`;
    }


    // ====================== IMAGE UPLOAD ======================
    const imgInput    = document.getElementById('imgInput');
    const previewGrid = document.getElementById('previewGrid');
    const uploadZone  = document.getElementById('uploadZone');

    if (!imgInput || !previewGrid || !uploadZone) return;

    let selectedFiles = [];

    imgInput.addEventListener('change', function () {
        handleFiles(Array.from(this.files));
    });

    uploadZone.addEventListener('dragover', e => {
        e.preventDefault();
        uploadZone.classList.add('dragging');
    });

    uploadZone.addEventListener('dragleave', () => {
        uploadZone.classList.remove('dragging');
    });

    uploadZone.addEventListener('drop', e => {
        e.preventDefault();
        uploadZone.classList.remove('dragging');
        const files = Array.from(e.dataTransfer.files).filter(f => f.type.match('image.*'));
        handleFiles(files);
    });

    function handleFiles(newFiles) {
        const MAX      = 20;
        const MAX_SIZE = 10 * 1024 * 1024;

        newFiles.forEach(file => {
            if (selectedFiles.length >= MAX) {
                alert('Chỉ được tải tối đa 20 ảnh');
                return;
            }
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
        reader.onload = e => {
            const item = document.createElement('div');
            item.className        = 'img-preview-item';
            item.dataset.index    = index;
            item.innerHTML        = `
                <img src="${e.target.result}" alt="preview">
                <button type="button" class="remove-btn" data-index="${index}">&times;</button>
            `;
            item.querySelector('.remove-btn').addEventListener('click', () => removeImage(index));
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
        const dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        imgInput.files = dt.files;
    }


    // ====================== SIDEBAR DRAWER (MOBILE) ======================
    const sidebarBtn     = document.getElementById('sidebarBtn');
    const sidebarDrawer  = document.getElementById('sidebarDrawer');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarClose   = document.getElementById('sidebarClose');

    function openDrawer()  { sidebarDrawer?.classList.add('open');    sidebarOverlay?.classList.add('show');    document.body.style.overflow = 'hidden'; }
    function closeDrawer() { sidebarDrawer?.classList.remove('open'); sidebarOverlay?.classList.remove('show'); document.body.style.overflow = '';       }

    sidebarBtn?.addEventListener('click', openDrawer);
    sidebarOverlay?.addEventListener('click', closeDrawer);
    sidebarClose?.addEventListener('click', closeDrawer);


    // ====================== SEARCH BÀI ĐĂNG ======================
    const postSearch = document.getElementById('postSearch');
    postSearch?.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('.post-manage-card').forEach(card => {
            const title = card.querySelector('.post-manage-title')?.textContent.toLowerCase() ?? '';
            card.style.display = (!q || title.includes(q)) ? '' : 'none';
        });
    });

}); // end DOMContentLoaded