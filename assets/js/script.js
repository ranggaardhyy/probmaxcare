
    function highlightChoice(inputElement, category) {
        // Ambil semua elemen radio dalam kategori yang sama
        const radioButtons = document.querySelectorAll(`input[name="selected_${category}"]`);
        
        // Reset semua pilihan dalam kategori
        radioButtons.forEach(button => {
            const label = button.closest('label');
            label.classList.remove('highlight', 'selected');
        });

        // Tambahkan efek pada label yang dipilih
        const selectedLabel = inputElement.closest('label');
        selectedLabel.classList.add('highlight', 'selected');
    }