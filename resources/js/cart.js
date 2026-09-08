document.addEventListener('DOMContentLoaded', () => {

    // Tambah qty
    document.querySelectorAll('.btn-qty-increase').forEach(button => {
        button.addEventListener('click', async () => {
            const id = button.dataset.id;

            try {
                const response = await fetch(`/cart/increase/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    location.reload();
                } else {
                    console.error('Gagal update qty:', response.status);
                }
            } catch (error) {
                console.error(error);
            }
        });
    });

    // Kurang qty
    document.querySelectorAll('.btn-qty-decrease').forEach(button => {
        button.addEventListener('click', async () => {
            const id = button.dataset.id;

            try {
                const response = await fetch(`/cart/decrease/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    location.reload();
                } else {
                    console.error('Gagal update qty:', response.status);
                }
            } catch (error) {
                console.error(error);
            }
        });
    });

});