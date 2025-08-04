<script>
// --- Variabel Global untuk Modal ---
const createModal = document.getElementById('createModal');
const editModal = document.getElementById('editModal');
const completeModal = document.getElementById('completeModal');
const editForm = document.getElementById('editForm');
const completeForm = document.getElementById('completeForm');
const createForm = document.querySelector('#createModal form');

// --- Fungsi Format Nominal ---
function formatNumber(input) {
    let rawValue = input.value.replace(/[^\d]/g, '');
    const hiddenInput = document.getElementById(input.id + '_raw');
    
    if (hiddenInput) {
        hiddenInput.value = rawValue;
    }
    
    if (rawValue) {
        input.value = parseInt(rawValue).toLocaleString('id-ID');
    } else {
        input.value = '';
    }
}

// --- Set Default Date Time ---
function setDefaultDateTime(inputId) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    input.value = now.toISOString().slice(0, 16);
}

// --- Event Listeners untuk DOMContentLoaded ---
document.addEventListener('DOMContentLoaded', function() {
    // Listener untuk format nominal
    const createNominalInput = document.getElementById('create_nominal');
    if(createNominalInput) createNominalInput.addEventListener('input', () => formatNumber(createNominalInput));

    const editNominalInput = document.getElementById('edit_nominal');
    if(editNominalInput) editNominalInput.addEventListener('input', () => formatNumber(editNominalInput));

    // Listener untuk submit form
    if(createForm) {
        createForm.addEventListener('submit', function(e) {
            const nominalInput = document.getElementById('create_nominal');
            const nominalRaw = document.getElementById('create_nominal_raw');
            if (nominalRaw && nominalRaw.value) {
                nominalInput.removeAttribute('name');
                nominalRaw.name = 'nominal';
            }
        });
    }

    if(editForm) {
        editForm.addEventListener('submit', function(e) {
            const nominalInput = document.getElementById('edit_nominal');
            const nominalRaw = document.getElementById('edit_nominal_raw');
            if (nominalRaw && nominalRaw.value) {
                nominalInput.removeAttribute('name');
                nominalRaw.name = 'nominal';
            }
        });
    }
    
    // Set default date untuk jatuh tempo di form create
    const createJatuhTempo = document.getElementById('create_jatuh_tempo');
    if(createJatuhTempo) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        createJatuhTempo.value = tomorrow.toISOString().split('T')[0];
    }
});

// --- Logika Modal Create ---
function openCreateModal() { 
    createModal.classList.remove('hidden'); 
}
function closeCreateModal() { 
    createModal.classList.add('hidden');
    if(createForm) createForm.reset();
    
    const createNominalRaw = document.getElementById('create_nominal_raw');
    if(createNominalRaw) createNominalRaw.value = '';

    const createJatuhTempo = document.getElementById('create_jatuh_tempo');
    if(createJatuhTempo) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        createJatuhTempo.value = tomorrow.toISOString().split('T')[0];
    }
}

// --- Logika Modal Edit ---
function openEditModal(item) {
    let url = '{{ route("planned-transactions.update", ":id") }}';
    url = url.replace(':id', item.id);
    editForm.action = url;

    document.getElementById('edit_keterangan').value = item.keterangan;
    document.getElementById('edit_nama').value = item.nama;
    document.getElementById('edit_jenis').value = item.jenis;
    
    // PERBAIKAN FINAL JATUH TEMPO: Gunakan accessor dari model
    if (item.jatuh_tempo_formatted) {
        document.getElementById('edit_jatuh_tempo').value = item.jatuh_tempo_formatted;
    }
    
    // PERBAIKAN: Set nominal raw value terlebih dahulu, lalu format tampilan
    const editNominalInput = document.getElementById('edit_nominal');
    const editNominalRaw = document.getElementById('edit_nominal_raw');
    
    // Set raw value ke hidden input
    if (editNominalRaw) {
        editNominalRaw.value = Math.round(parseFloat(item.nominal));
    }
    
    // Set dan format tampilan nominal
    editNominalInput.value = Math.round(parseFloat(item.nominal)).toLocaleString('id-ID');
    
    // Set tanggal peristiwa jika ada, jika tidak, kosongkan.
    const editTanggalPeristiwa = document.getElementById('edit_tanggal_peristiwa');
    if (item.tanggal_peristiwa) {
        const date = new Date(item.tanggal_peristiwa);
        if (!isNaN(date.getTime())) {
            date.setMinutes(date.getMinutes() - date.getTimezoneOffset());
            editTanggalPeristiwa.value = date.toISOString().slice(0, 16);
        }
    } else {
        if(editTanggalPeristiwa) editTanggalPeristiwa.value = '';
    }
    
    editModal.classList.remove('hidden');
}
function closeEditModal() { 
    editModal.classList.add('hidden'); 
}

// --- Logika Modal Selesaikan (Complete) ---
function openCompleteModal(item) {
    const infoElement = document.getElementById('completeModalInfo');
    const formattedNominal = new Intl.NumberFormat('id-ID').format(item.nominal);
    infoElement.innerHTML = `${item.keterangan} <br> <span class="text-indigo-600">Rp ${formattedNominal}</span>`;

    const tanggalInput = document.getElementById('tanggal_peristiwa');
    
    if (item.tanggal_peristiwa) {
        const date = new Date(item.tanggal_peristiwa);
        if (!isNaN(date.getTime())) {
            date.setMinutes(date.getMinutes() - date.getTimezoneOffset());
            tanggalInput.value = date.toISOString().slice(0, 16);
        }
    } else {
        setDefaultDateTime('tanggal_peristiwa');
    }

    let url = '{{ route("planned-transactions.complete", ":id") }}';
    url = url.replace(':id', item.id);
    completeForm.action = url;
    
    completeModal.classList.remove('hidden');
}
function closeCompleteModal() { 
    completeModal.classList.add('hidden'); 
}

function openReadMoreModal(item) {
    document.getElementById('readMoreDescription').textContent = item.keterangan;
    document.getElementById('readMoreModal').classList.remove('hidden');
}

function closeReadMoreModal() {
    document.getElementById('readMoreModal').classList.add('hidden');
    document.getElementById('readMoreDescription').textContent = '';
}
</script>
