<form method="POST" action="{{ route('backup.download') }}" class="w-full lg:w-80">
    @csrf
    <div class="space-y-4">
        <div>
            <label for="format" class="block text-sm font-bold text-gray-700 mb-3">
                <i class="fas fa-file-export mr-2 text-blue-600"></i>
                Pilih Format Export:
            </label>
            <select name="format" id="format" class="w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 font-medium text-gray-700" required>
                <option value="" class="text-gray-400">-- Pilih Format --</option>
                <option value="json">📄 JSON (Data Lengkap)</option>
                <option value="csv">📊 CSV (Excel Compatible)</option>
            </select>
        </div>
        
        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold py-4 px-6 rounded-2xl hover:from-blue-700 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105 flex items-center justify-center shadow-lg">
            <i class="fas fa-cloud-download-alt mr-3 text-lg"></i>
            Download Backup
        </button>
    </div>
    
    <div class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl border border-blue-100">
        <div class="flex items-start text-blue-800 text-sm">
            <i class="fas fa-info-circle mr-3 mt-0.5 text-blue-600"></i>
            <div>
                <p class="font-semibold mb-1">Tips Backup:</p>
                <p class="text-xs text-blue-700">Lakukan backup secara berkala untuk menjaga keamanan data keuanganmu</p>
            </div>
        </div>
    </div>
</form>