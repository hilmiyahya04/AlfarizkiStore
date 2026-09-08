

    <div style="
        width:100%;
        background:#FFC000;
        border-radius:18px;
        padding:35px 45px;
        color:white;
        box-sizing:border-box;
    ">

        <div style="
            display:flex;
            align-items:center;
            gap:25px;
        ">

            <div style="
                width:80px;
                height:80px;
                background:rgba(255,255,255,.12);
                border-radius:50%;
                display:flex;
                justify-content:center;
                align-items:center;
                font-size:40px;
                flex-shrink:0;
            ">
                🛍️
            </div>

            <div style="flex:1;">

                <h1 style="
                    margin:0;
                    font-size:34px;
                    font-weight:bold;
                    color:#fff;
                ">
                    Selamat Datang,
                    <span style="color:#facc15;">
                        {{ auth()->user()->name }}
                    </span>
                    👋
                </h1>

                <p style="
                    margin-top:15px;
                    margin-bottom:25px;
                    color:#dbeafe;
                    font-size:17px;
                    line-height:1.8;
                ">
                    Terima kasih telah bergabung di
                    <strong>Toko Alfarizki</strong>.
                    Jelajahi berbagai produk sepatu dan sandal terbaik.
                    Sistem rekomendasi kami akan membantu Anda menemukan
                    produk yang sesuai dengan riwayat pembelian Anda.
                </p>

                <div style="display:flex;gap:15px;">

                    <a href="/"
                        style="
                            background:#ffffff;
                            color:#0f172a;
                            padding:12px 24px;
                            border-radius:10px;
                            text-decoration:none;
                            font-weight:bold;
                        ">
                        🛒 Mulai Belanja
                    </a>

                    <a href="/#Recommendations"
                        style="
                            border:1px solid rgba(255,255,255,.35);
                            color:white;
                            padding:12px 24px;
                            border-radius:10px;
                            text-decoration:none;
                            font-weight:bold;
                        ">
                        ⭐ Lihat Rekomendasi
                    </a>

                </div>

            </div>

        </div>

    </div>
