<div class="row row-cols-1 row-cols-lg-6 mb-3">
    <div class="feature col">
        <div class="bg-white p-2 border shadow-sm rounded-3 d-flex align-items-center position-relative">
            <img src="{{ asset('assets/icons/ic-gear.png') }}" height="20" alt="" class="me-2">
            <a href="{{ route('admin.posts.index') }}" class="text-decoration-none text-dark fw-bold">Data Post
                (Admin)</a>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                {{ $postsCount }} <!-- Menampilkan jumlah post -->
                <span class="visually-hidden">unread messages</span>
            </span>
        </div>
    </div>
</div>
