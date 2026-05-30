<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aspal Seru - Sewa Kendaraan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        
        /* Custom Colors untuk mempermudah (mengikuti Desktop) */
        .text-brand-primary { color: #0EA5E9; }
        .bg-brand-primary { background-color: #0EA5E9; }
        .bg-brand-navy { background-color: #162740; }
        .text-brand-navy { color: #162740; }
        
        /* Hide scrollbar untuk filter menu di mobile */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="pb-20 md:pb-0 text-slate-800">

    <div class="md:hidden sticky top-0 z-40">
        <div class="bg-brand-navy text-white p-4 flex justify-between items-center shadow-md">
            <h1 class="font-bold text-lg tracking-wide">Aspal Seru</h1>
            <div class="flex flex-col gap-1.5 cursor-pointer">
                <div class="w-6 h-0.5 bg-white/80 rounded"></div>
                <div class="w-6 h-0.5 bg-white/80 rounded"></div>
                <div class="w-4 h-0.5 bg-white/80 rounded ml-auto"></div>
            </div>
        </div>
        
        <div class="p-4 bg-white border-b border-slate-200 shadow-sm">
            <div class="text-[11px] text-slate-500 mb-2 font-medium">Beranda / Katalog</div>
            <div class="flex gap-2 mb-3">
                <input type="text" placeholder="Cari kendaraan..." class="w-full bg-slate-50 rounded-lg px-4 py-2 text-sm outline-none border border-slate-200 focus:border-[#0EA5E9] focus:bg-white transition-all">
                <button class="bg-brand-primary hover:bg-sky-600 transition-colors text-white px-5 py-2 rounded-lg text-sm font-medium shadow-sm">Cari</button>
            </div>
            <div class="flex gap-2 overflow-x-auto pb-1 hide-scrollbar">
                <button class="bg-brand-primary text-white px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap shadow-sm">Semua</button>
                <button class="bg-white border border-slate-300 text-slate-600 px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap hover:bg-slate-50 transition-colors">Motor</button>
                <button class="bg-white border border-slate-300 text-slate-600 px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap hover:bg-slate-50 transition-colors">Mobil</button>
            </div>
        </div>
    </div>

    <nav class="hidden md:flex justify-between items-center px-8 py-4 bg-white border-b border-slate-200">
        <div class="flex items-center gap-12">
            <div>
                <h1 class="font-bold text-2xl text-brand-navy leading-tight">Aspal Seru</h1>
                <p class="text-[10px] text-brand-primary tracking-[0.2em] font-semibold uppercase">Purwokerto</p>
            </div>
            <div class="flex gap-8 text-sm font-medium text-slate-500">
                <a href="#" class="text-brand-navy border-b-2 border-brand-navy pb-1">Katalog</a>
                <a href="#" class="hover:text-brand-navy transition-colors">Cara Sewa</a>
                <a href="#" class="hover:text-brand-navy transition-colors">Kontak</a>
            </div>
        </div>
        
        <div class="flex items-center gap-6">
            <div class="relative">
                <input type="text" placeholder="Cari kendaraan, tipe..." class="bg-slate-100 rounded-full pl-4 pr-10 py-2 text-sm w-72 outline-none border border-transparent focus:border-slate-300 focus:bg-white transition-all">
                <span class="absolute right-3 top-2 text-brand-primary text-lg font-bold">⌕</span>
            </div>
            <div class="flex items-center gap-4 text-sm font-medium">
                <a href="/login" class="text-slate-600 hover:text-brand-navy">Masuk</a>
                <a href="/register" class="bg-brand-navy hover:bg-slate-800 transition-colors text-white px-5 py-2 rounded-md shadow-sm">Daftar</a>
                <a href="#" class="bg-brand-primary hover:bg-sky-600 transition-colors text-white px-5 py-2 rounded-md shadow-sm">+ Sewa Kini</a>
            </div>
        </div>
    </nav>

    <div class="hidden md:flex bg-brand-navy w-full h-[420px]">
        <div class="w-1/2 p-16 pl-24 flex flex-col justify-center">
            <h1 class="text-white text-5xl font-bold leading-tight mb-5 tracking-tight">Sewa Kendaraan<br><span class="text-brand-primary">Tanpa Ribet.</span></h1>
            <p class="text-slate-300 text-base mb-10 w-4/5 font-light">Motor & Mobil berkualitas di Purwokerto — siap antar, siap jalan. Nikmati perjalanan Anda tanpa khawatir.</p>
            <div class="flex gap-4">
                <button class="bg-brand-primary hover:bg-sky-600 transition-colors text-white px-8 py-3 rounded-md font-medium shadow-md">Lihat Katalog</button>
                <button class="bg-white/10 hover:bg-white/20 transition-colors text-white px-8 py-3 rounded-md flex items-center gap-2 font-medium border border-white/10">Cara Sewa &rarr;</button>
            </div>
        </div>
        <div class="w-1/2 p-16 pr-24 flex gap-4 items-center">
            <div class="w-1/3 h-64 bg-slate-800/50 border border-slate-700/50 rounded-xl shadow-2xl backdrop-blur-sm"></div>
            <div class="w-1/3 h-80 bg-slate-800/80 border border-slate-700 rounded-xl shadow-2xl backdrop-blur-sm"></div>
            <div class="w-1/3 h-64 bg-slate-800/50 border border-slate-700/50 rounded-xl shadow-2xl backdrop-blur-sm"></div>
        </div>
    </div>

    <div class="hidden md:flex bg-white border-b border-slate-200 justify-center gap-24 items-center py-8">
        <div class="text-center"><div class="text-3xl font-bold text-brand-navy">34+</div><div class="text-[11px] text-slate-400 font-semibold uppercase tracking-widest mt-1">Armada</div></div>
        <div class="w-px h-10 bg-slate-200"></div>
        <div class="text-center"><div class="text-3xl font-bold text-brand-navy">412</div><div class="text-[11px] text-slate-400 font-semibold uppercase tracking-widest mt-1">Pelanggan</div></div>
        <div class="w-px h-10 bg-slate-200"></div>
        <div class="text-center"><div class="text-3xl font-bold text-brand-navy">4.9</div><div class="text-[11px] text-slate-400 font-semibold uppercase tracking-widest mt-1">Rating</div></div>
        <div class="w-px h-10 bg-slate-200"></div>
        <div class="text-center"><div class="text-3xl font-bold text-brand-navy">2020</div><div class="text-[11px] text-slate-400 font-semibold uppercase tracking-widest mt-1">Berdiri</div></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-10">
        
        <div class="hidden md:flex justify-between items-center border-b border-slate-200 pb-4 mb-8">
            <div class="flex gap-8 text-sm font-semibold text-slate-400 tracking-wide">
                <a href="#" class="text-brand-primary border-b-2 border-brand-primary pb-4 -mb-[18px]">SEMUA</a>
                <a href="#" class="hover:text-slate-800 transition-colors">MOTOR</a>
                <a href="#" class="hover:text-slate-800 transition-colors">MOBIL</a>
                <a href="#" class="hover:text-slate-800 transition-colors">MATIC</a>
                <a href="#" class="hover:text-slate-800 transition-colors">MANUAL</a>
            </div>
            <div class="text-xs text-slate-500 font-medium flex items-center gap-2 cursor-pointer hover:text-slate-800 transition-colors">
                Urutkan: Harga Terendah <span class="text-brand-primary font-bold text-sm">v</span>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8">
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition-shadow flex flex-col overflow-hidden">
                <div class="h-32 md:h-44 bg-slate-100 w-full relative">
                    </div> 
                <div class="p-3 md:p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-slate-800 text-sm md:text-base leading-tight">Honda Beat 2023</h3>
                    <p class="hidden md:block text-[10px] text-slate-400 mt-1.5 font-semibold uppercase tracking-wider">MOTOR · MATIC · 125CC</p>
                    
                    <div class="mt-2 md:mt-4">
                        <span class="text-brand-primary font-bold text-sm md:text-xl">Rp 75.000</span>
                        <span class="text-[10px] md:text-xs text-slate-500 font-medium">/ hari</span>
                    </div>
                    <p class="hidden md:block text-[11px] text-slate-500 mt-1">- sudah termasuk helm</p>
                    <p class="md:hidden text-[10px] text-slate-500 mt-0.5">Motor - Matic</p>

                    <div class="mt-auto pt-4 md:pt-6 flex justify-between items-center">
                        <span class="hidden md:flex items-center gap-1.5 bg-green-50 text-green-600 text-[11px] font-semibold px-2.5 py-1 rounded-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Tersedia
                        </span>
                        <button class="w-full md:w-auto bg-brand-primary text-white text-xs md:text-sm font-semibold px-4 py-2 md:py-2.5 rounded-lg hover:bg-sky-600 transition-colors shadow-sm">
                            Pesan <span class="md:hidden">Sekarang</span><span class="hidden md:inline"> &rarr;</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border-2 border-brand-primary flex flex-col overflow-hidden relative">
                <div class="absolute top-0 right-0 bg-brand-primary text-white text-[10px] font-bold px-3 py-1 uppercase tracking-wider rounded-bl-lg z-10 shadow-sm">Populer</div>
                <div class="h-32 md:h-44 bg-sky-50 w-full relative"></div>
                <div class="p-3 md:p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-slate-800 text-sm md:text-base leading-tight">Honda Vario 160</h3>
                    <p class="hidden md:block text-[10px] text-slate-400 mt-1.5 font-semibold uppercase tracking-wider">MOTOR · MATIC · 160CC</p>
                    <div class="mt-2 md:mt-4">
                        <span class="text-brand-primary font-bold text-sm md:text-xl">Rp 85.000</span>
                        <span class="text-[10px] md:text-xs text-slate-500 font-medium">/ hari</span>
                    </div>
                    <p class="hidden md:block text-[11px] text-slate-500 mt-1">- sudah termasuk helm</p>
                    <p class="md:hidden text-[10px] text-slate-500 mt-0.5">Motor - Matic</p>

                    <div class="mt-auto pt-4 md:pt-6 flex justify-between items-center">
                        <span class="hidden md:flex items-center gap-1.5 bg-green-50 text-green-600 text-[11px] font-semibold px-2.5 py-1 rounded-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Tersedia
                        </span>
                        <button class="w-full md:w-auto bg-brand-primary text-white text-xs md:text-sm font-semibold px-4 py-2 md:py-2.5 rounded-lg hover:bg-sky-600 transition-colors shadow-sm">
                            Pesan <span class="md:hidden">Sekarang</span><span class="hidden md:inline"> &rarr;</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition-shadow flex flex-col overflow-hidden">
                <div class="h-32 md:h-44 bg-slate-100 w-full relative"></div>
                <div class="p-3 md:p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-slate-800 text-sm md:text-base leading-tight">Toyota Avanza 2022</h3>
                    <p class="hidden md:block text-[10px] text-slate-400 mt-1.5 font-semibold uppercase tracking-wider">MOBIL · MANUAL · 1.3L</p>
                    <div class="mt-2 md:mt-4">
                        <span class="text-brand-primary font-bold text-sm md:text-xl">Rp 280.000</span>
                        <span class="text-[10px] md:text-xs text-slate-500 font-medium">/ hari</span>
                    </div>
                    <p class="hidden md:block text-[11px] text-slate-500 mt-1">- kapasitas 7 penumpang</p>
                    <p class="md:hidden text-[10px] text-slate-500 mt-0.5">Mobil - Manual</p>

                    <div class="mt-auto pt-4 md:pt-6 flex justify-between items-center">
                        <span class="hidden md:flex items-center gap-1.5 bg-green-50 text-green-600 text-[11px] font-semibold px-2.5 py-1 rounded-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Tersedia
                        </span>
                        <button class="w-full md:w-auto bg-brand-primary text-white text-xs md:text-sm font-semibold px-4 py-2 md:py-2.5 rounded-lg hover:bg-sky-600 transition-colors shadow-sm">
                            Pesan <span class="md:hidden">Sekarang</span><span class="hidden md:inline"> &rarr;</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition-shadow flex flex-col overflow-hidden">
                <div class="h-32 md:h-44 bg-slate-100 w-full relative"></div>
                <div class="p-3 md:p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-slate-800 text-sm md:text-base leading-tight">Daihatsu Xenia 2021</h3>
                    <p class="hidden md:block text-[10px] text-slate-400 mt-1.5 font-semibold uppercase tracking-wider">MOBIL · MATIC · 1.3L</p>
                    <div class="mt-2 md:mt-4">
                        <span class="text-brand-primary font-bold text-sm md:text-xl">Rp 260.000</span>
                        <span class="text-[10px] md:text-xs text-slate-500 font-medium">/ hari</span>
                    </div>
                    <p class="hidden md:block text-[11px] text-slate-500 mt-1">- kapasitas 7 penumpang</p>
                    <p class="md:hidden text-[10px] text-slate-500 mt-0.5">Mobil - Matic</p>

                    <div class="mt-auto pt-4 md:pt-6 flex justify-between items-center">
                        <span class="hidden md:flex items-center gap-1.5 bg-green-50 text-green-600 text-[11px] font-semibold px-2.5 py-1 rounded-md">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Tersedia
                        </span>
                        <button class="w-full md:w-auto bg-brand-primary text-white text-xs md:text-sm font-semibold px-4 py-2 md:py-2.5 rounded-lg hover:bg-sky-600 transition-colors shadow-sm">
                            Pesan <span class="md:hidden">Sekarang</span><span class="hidden md:inline"> &rarr;</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 flex justify-around py-3 px-2 z-50 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        <a href="#" class="flex flex-col items-center gap-1.5 bg-sky-50 px-5 py-1.5 rounded-xl">
            <div class="w-5 h-5 rounded bg-brand-primary/20 flex items-center justify-center">
                <span class="w-2.5 h-2.5 bg-brand-primary rounded-sm"></span>
            </div>
            <span class="text-[10px] font-bold text-brand-primary">Beranda</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1.5 text-slate-400 px-5 py-1.5 hover:text-slate-600 transition-colors">
            <div class="w-5 h-5 rounded bg-slate-200"></div>
            <span class="text-[10px] font-medium">Pesan</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1.5 text-slate-400 px-5 py-1.5 hover:text-slate-600 transition-colors">
            <div class="w-5 h-5 rounded bg-slate-200"></div>
            <span class="text-[10px] font-medium">Riwayat</span>
        </a>
        <a href="#" class="flex flex-col items-center gap-1.5 text-slate-400 px-5 py-1.5 hover:text-slate-600 transition-colors">
            <div class="w-5 h-5 rounded bg-slate-200"></div>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </div>

</body>
</html>