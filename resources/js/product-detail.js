document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.color-option').forEach(button => {
        button.addEventListener('click', function () {

            document.querySelectorAll('.color-option').forEach(btn => {
                btn.classList.remove(
                    'border-[#0D2031]',
                    'bg-[#0D2031]',
                    'text-white'
                );
            });

            this.classList.add(
                'border-[#0D2031]',
                'bg-[#0D2031]',
                'text-white'
            );

            // Form Keranjang
            const color1 = document.getElementById('selectedColor');
            if (color1) color1.value = this.dataset.color;

            // Form Pesan
            const color2 = document.getElementById('selectedColor2');
            if (color2) color2.value = this.dataset.color;
        });
    });

    document.querySelectorAll('.size-option').forEach(button => {
        button.addEventListener('click', function () {

            document.querySelectorAll('.size-option').forEach(btn => {
                btn.classList.remove(
                    'border-[#0D2031]',
                    'bg-[#0D2031]',
                    'text-white'
                );
            });

            this.classList.add(
                'border-[#0D2031]',
                'bg-[#0D2031]',
                'text-white'
            );

            // Form Keranjang
            const size1 = document.getElementById('selectedSize');
            if (size1) size1.value = this.dataset.size;

            // Form Pesan
            const size2 = document.getElementById('selectedSize2');
            if (size2) size2.value = this.dataset.size;
        });
    });

});