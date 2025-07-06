const { createApp } = Vue

// Try multiple possible API URLs
const possibleApiUrls = [
  'http://localhost:8080',
  'http://127.0.0.1:8080',
  'http://localhost/ci4/public',
  'http://127.0.0.1/ci4/public',
  'http://localhost:80/ci4/public'
]

let apiUrl = possibleApiUrls[0] // Default

createApp({
  data() {
    return {
      artikel: [],
      kategori: [],
      formData: {
        id: null,
        judul: '',
        isi: '',
        status: 0,
        gambar: null,
        id_kategori: null
      },
      selectedFile: null,
      imagePreview: null,
      isUploading: false,
      showForm: false,
      showKategoriForm: false,
      formTitle: 'Tambah Data',
      kategoriFormData: {
        id_kategori: null,
        nama_kategori: ''
      },
      statusOptions: [
        { text: 'Draft', value: 0 },
        { text: 'Publish', value: 1 }
      ],
      isLoading: true,
      errorMessage: null
    }
  },
  mounted() {
    this.loadData()
    this.loadKategori()
  },
  methods: {
    async loadData() {
      this.isLoading = true
      this.errorMessage = null

      // Try each possible API URL
      for (let i = 0; i < possibleApiUrls.length; i++) {
        try {
          console.log(`Trying API URL: ${possibleApiUrls[i]}/post`)

          const response = await axios.get(possibleApiUrls[i] + '/post', {
            timeout: 5000, // 5 second timeout
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          })

          console.log('API Response:', response.data)
          this.artikel = response.data.artikel || []
          apiUrl = possibleApiUrls[i] // Set working API URL
          this.isLoading = false
          return // Success, exit the loop

        } catch (err) {
          console.error(`Failed with URL ${possibleApiUrls[i]}:`, err)

          if (i === possibleApiUrls.length - 1) {
            // Last attempt failed
            this.isLoading = false
            this.errorMessage = this.getErrorMessage(err)
            console.error('All API URLs failed. Error details:', err)
          }
        }
      }
    },

    async loadKategori() {
      // Try each possible API URL for kategori
      for (let i = 0; i < possibleApiUrls.length; i++) {
        try {
          console.log(`Loading kategori from: ${possibleApiUrls[i]}/kategori`)

          const response = await axios.get(possibleApiUrls[i] + '/kategori', {
            timeout: 5000,
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          })

          console.log('Kategori Response:', response.data)
          this.kategori = response.data.kategori || []
          return // Success, exit the loop

        } catch (err) {
          console.error(`Failed to load kategori from ${possibleApiUrls[i]}:`, err)

          if (i === possibleApiUrls.length - 1) {
            // Last attempt failed, but don't show error for kategori
            console.error('All kategori API URLs failed, using empty array')
            this.kategori = []
          }
        }
      }
    },

    getErrorMessage(err) {
      if (err.code === 'ECONNABORTED') {
        return 'Koneksi timeout. Pastikan server CodeIgniter 4 berjalan di http://localhost:8080'
      } else if (err.response) {
        return `Server error: ${err.response.status} - ${err.response.data?.message || err.response.statusText}`
      } else if (err.request) {
        return 'Tidak dapat terhubung ke server. Pastikan:\n1. Server CodeIgniter 4 berjalan di http://localhost:8080\n2. CORS sudah dikonfigurasi dengan benar\n3. Database terhubung dengan baik'
      } else {
        return `Error: ${err.message}`
      }
    },
    tambah() {
      if (this.errorMessage) {
        alert('Silakan perbaiki koneksi ke server terlebih dahulu')
        return
      }
      this.showForm = true
      this.formTitle = 'Tambah Data'
      this.formData = { id: null, judul: '', isi: '', status: 0, gambar: null, id_kategori: null }
      this.selectedFile = null
      this.imagePreview = null
    },
    edit(row) {
      if (this.errorMessage) {
        alert('Silakan perbaiki koneksi ke server terlebih dahulu')
        return
      }
      this.showForm = true
      this.formTitle = 'Ubah Data'
      this.formData = { ...row }
      this.selectedFile = null
      this.imagePreview = null
    },
    hapus(index, id) {
      if (this.errorMessage) {
        alert('Silakan perbaiki koneksi ke server terlebih dahulu')
        return
      }
      if (confirm('Yakin ingin menghapus data ini?')) {
        axios.delete(apiUrl + '/post/' + id, {
          timeout: 5000,
          headers: {
            'Accept': 'application/json'
          }
        })
          .then(() => {
            this.artikel.splice(index, 1)
            alert('Data berhasil dihapus')
          })
          .catch(err => {
            console.error('Error deleting data:', err)
            alert('Error deleting data: ' + this.getErrorMessage(err))
          })
      }
    },
    saveData() {
      if (this.errorMessage) {
        alert('Silakan perbaiki koneksi ke server terlebih dahulu')
        return
      }

      this.isUploading = true

      // Create FormData for file upload
      const formData = new FormData()
      formData.append('judul', this.formData.judul)
      formData.append('isi', this.formData.isi)
      formData.append('status', this.formData.status)
      if (this.formData.id_kategori) {
        formData.append('id_kategori', this.formData.id_kategori)
      }

      if (this.selectedFile) {
        formData.append('gambar', this.selectedFile)
      }

      // For updates, add method override to use POST instead of PUT
      if (this.formData.id) {
        formData.append('_method', 'PUT')
      }

      const url = this.formData.id
        ? apiUrl + '/post/' + this.formData.id
        : apiUrl + '/post'

      // Don't set Content-Type header manually - let Axios handle it for FormData
      const config = {
        timeout: 10000, // 10 second timeout for uploads
        headers: {
          // Remove Content-Type to let browser set it with boundary
        }
      }

      // Always use POST for FormData (with _method override for updates)
      axios.post(url, formData, config)
        .then((response) => {
          console.log('Save response:', response.data)
          this.loadData()
          this.closeModal()
          alert('Data berhasil disimpan')
        })
        .catch(err => {
          console.error('Error saving data:', err)
          console.error('Error details:', err.response)
          alert('Error saving data: ' + this.getErrorMessage(err))
        })
        .finally(() => {
          this.isUploading = false
        })
    },
    statusText(status) {
      return status == 1 ? 'Publish' : 'Draft'
    },
    closeModal() {
      this.showForm = false
      this.formData = { id: null, judul: '', isi: '', status: 0, gambar: null, id_kategori: null }
      this.selectedFile = null
      this.imagePreview = null
      this.isUploading = false
      // Reset file input
      if (this.$refs.fileInput) {
        this.$refs.fileInput.value = ''
      }
    },
    handleFileUpload(event) {
      const file = event.target.files[0]
      if (file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']
        if (!allowedTypes.includes(file.type)) {
          alert('File harus berupa gambar (JPEG, PNG, GIF)')
          event.target.value = ''
          return
        }

        // Validate file size (2MB)
        if (file.size > 2048000) {
          alert('Ukuran file maksimal 2MB')
          event.target.value = ''
          return
        }

        this.selectedFile = file

        // Create preview
        const reader = new FileReader()
        reader.onload = (e) => {
          this.imagePreview = e.target.result
        }
        reader.readAsDataURL(file)
      }
    },
    removeImage() {
      this.selectedFile = null
      this.imagePreview = null
      if (this.$refs.fileInput) {
        this.$refs.fileInput.value = ''
      }
    },
    removeExistingImage() {
      this.formData.gambar = null
    },

    // Kategori Management Methods
    showKategoriModal() {
      this.showKategoriForm = true
      this.kategoriFormData = { id_kategori: null, nama_kategori: '' }
    },

    closeKategoriModal() {
      this.showKategoriForm = false
      this.kategoriFormData = { id_kategori: null, nama_kategori: '' }
    },

    async saveKategori() {
      if (!this.kategoriFormData.nama_kategori.trim()) {
        alert('Nama kategori harus diisi')
        return
      }

      try {
        const response = await axios.post(apiUrl + '/kategori', {
          nama_kategori: this.kategoriFormData.nama_kategori
        }, {
          timeout: 5000,
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        })

        console.log('Kategori saved:', response.data)
        this.loadKategori() // Reload kategori list
        this.closeKategoriModal()
        alert('Kategori berhasil ditambahkan')

      } catch (err) {
        console.error('Error saving kategori:', err)
        console.error('Error response:', err.response)
        let errorMsg = 'Error saving kategori: ' + this.getErrorMessage(err)
        if (err.response && err.response.data) {
          errorMsg += '\nDetail: ' + JSON.stringify(err.response.data)
        }
        alert(errorMsg)
      }
    },

    getNamaKategori(id_kategori) {
      if (!id_kategori) return 'Tidak ada kategori'
      const kategori = this.kategori.find(k => k.id_kategori == id_kategori)
      return kategori ? kategori.nama_kategori : 'Tidak ada kategori'
    },

    async deleteKategori(id_kategori, nama_kategori) {
      // Konfirmasi sebelum menghapus
      if (!confirm(`Yakin ingin menghapus kategori "${nama_kategori}"?`)) {
        return
      }

      try {
        console.log('Deleting kategori with ID:', id_kategori)

        const response = await axios.delete(apiUrl + '/kategori/' + id_kategori, {
          timeout: 5000,
          headers: {
            'Accept': 'application/json'
          }
        })

        console.log('Delete response:', response.data)

        // Reload kategori list setelah berhasil hapus
        await this.loadKategori()
        alert('Kategori berhasil dihapus!')

      } catch (err) {
        console.error('Error deleting kategori:', err)
        console.error('Error response:', err.response)
        let errorMsg = 'Error menghapus kategori: ' + this.getErrorMessage(err)
        if (err.response && err.response.data) {
          errorMsg += '\nDetail: ' + JSON.stringify(err.response.data)
        }
        alert(errorMsg)
      }
    }
  }
}).mount('#app')
