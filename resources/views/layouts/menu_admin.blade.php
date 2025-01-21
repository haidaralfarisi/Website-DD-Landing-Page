<div class="row row-cols-1 row-cols-lg-6 mb-2">
    <div class="feature col">
        <div class="bg-white p-3 border shadow-sm rounded-3 d-flex align-items-center position-relative hover-effect custom-width">
            <!-- Ikon -->
            <img src="{{ asset('assets/icons/user.png') }}" height="40" alt="" class="me-2">
            <!-- Teks -->
            <a href="{{ route('admin.posts.index') }}" class="text-decoration-none text-dark fw-bold">
                Data Post (Admin)
            </a>
            <!-- Badge Jumlah -->
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                {{ $postsCount }} <!-- Menampilkan jumlah post -->
                <span class="visually-hidden">unread messages</span>
            </span>
        </div>
    </div>
</div>




