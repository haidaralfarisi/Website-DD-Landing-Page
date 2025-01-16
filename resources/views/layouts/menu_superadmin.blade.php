<div class="row row-cols-1 row-cols-lg-3 g-4 mb-4">

    <!-- Bagian User -->
    <div class="feature col">
        <a href="{{ route('users.index') }}"
            class="d-flex align-items-center text-decoration-none text-dark fw-bold fs-5 w-100 p-0">
            <div
                class="bg-white p-4 border shadow-sm rounded-3 d-flex align-items-center position-relative hover-effect w-100 w-md-75 w-lg-50 mx-auto">
                <!-- Ikon -->
                <img src="{{ asset('assets/icons/user.png') }}" height="40" alt="" class="me-3">
                <div class="d-flex flex-column">
                    <!-- Teks -->
                    Data User
                </div>
                <!-- Badge jumlah -->
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                    {{ $usersCount }} <!-- Menampilkan jumlah users -->
                    <span class="visually-hidden">unread messages</span>
                </span>
            </div>
        </a>
    </div>

    <!-- Bagian Post Category -->
    <div class="feature col">
        <a href="{{ route('postcategories.index') }}"
            class="d-flex align-items-center text-decoration-none text-dark fw-bold fs-5 w-100 p-0">
            <div
                class="bg-white p-4 border shadow-sm rounded-3 d-flex align-items-center position-relative hover-effect w-100 w-md-75 w-lg-50 mx-auto">
                <!-- Ikon -->
                <img src="{{ asset('assets/icons/categories.png') }}" height="40" alt="" class="me-3">
                <div class="d-flex flex-column">
                    <!-- Teks -->
                    Data Post Categories
                </div>
                <!-- Badge jumlah -->
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                    {{ $postcategoriesCount }} <!-- Menampilkan jumlah users -->
                    <span class="visually-hidden">unread messages</span>
                </span>
            </div>
        </a>
    </div>

    <!-- Bagian Video -->
    <div class="feature col">
        <a href="{{ route('video.index') }}"
            class="d-flex align-items-center text-decoration-none text-dark fw-bold fs-5 w-100 p-0">
            <div
                class="bg-white p-4 border shadow-sm rounded-3 d-flex align-items-center position-relative hover-effect w-100 w-md-75 w-lg-50 mx-auto">
                <!-- Ikon -->
                <img src="{{ asset('assets/icons/youtube.png') }}" height="40" alt="" class="me-3">
                <div class="d-flex flex-column">
                    <!-- Teks -->
                    Data Video
                </div>
                <!-- Badge jumlah -->
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                    {{ $videosCount }} <!-- Menampilkan jumlah users -->
                    <span class="visually-hidden">unread messages</span>
                </span>
            </div>
        </a>
    </div>

    <!-- Bagian Post -->
    <div class="feature col">
        <a href="{{ route('superadmin.posts.index') }}"
            class="d-flex align-items-center text-decoration-none text-dark fw-bold fs-5 w-100 p-0">
            <div
                class="bg-white p-4 border shadow-sm rounded-3 d-flex align-items-center position-relative hover-effect w-100 w-md-75 w-lg-50 mx-auto">
                <!-- Ikon -->
                <img src="{{ asset('assets/icons/post.png') }}" height="40" alt="" class="me-3">
                <div class="d-flex flex-column">
                    <!-- Teks -->
                    Data Post
                </div>
                <!-- Badge jumlah -->
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                    {{ $postsCount }} <!-- Menampilkan jumlah users -->
                    <span class="visually-hidden">unread messages</span>
                </span>
            </div>
        </a>
    </div>

    <!-- Bagian Unit -->
    <div class="feature col">
        <a href="{{ route('unit.index') }}"
            class="d-flex align-items-center text-decoration-none text-dark fw-bold fs-5 w-100 p-0">
            <div
                class="bg-white p-4 border shadow-sm rounded-3 d-flex align-items-center position-relative hover-effect w-100 w-md-75 w-lg-50 mx-auto">
                <!-- Ikon -->
                <img src="{{ asset('assets/icons/unit.png') }}" height="40" alt="" class="me-3">
                <div class="d-flex flex-column">
                    <!-- Teks -->
                    Data Unit
                </div>
                <!-- Badge jumlah -->
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                    {{ $unitsCount }} <!-- Menampilkan jumlah users -->
                    <span class="visually-hidden">unread messages</span>
                </span>
            </div>
        </a>
    </div>

    <!-- Bagian Slider -->
    <div class="feature col">
        <a href="{{ route('slider.index') }}"
            class="d-flex align-items-center text-decoration-none text-dark fw-bold fs-5 w-100 p-0">
            <div
                class="bg-white p-4 border shadow-sm rounded-3 d-flex align-items-center position-relative hover-effect w-100 w-md-75 w-lg-50 mx-auto">
                <!-- Ikon -->
                <img src="{{ asset('assets/icons/slider.png') }}" height="40" alt="" class="me-3">
                <div class="d-flex flex-column">
                    <!-- Teks -->
                    Data Sliders
                </div>
                <!-- Badge jumlah -->
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                    {{ $slidersCount }} <!-- Menampilkan jumlah users -->
                    <span class="visually-hidden">unread messages</span>
                </span>
            </div>
        </a>
    </div>

    <!-- Bagian Achievement -->
    <div class="feature col">
        <a href="{{ route('achievement.index') }}"
            class="d-flex align-items-center text-decoration-none text-dark fw-bold fs-5 w-100 p-0">
            <div
                class="bg-white p-4 border shadow-sm rounded-3 d-flex align-items-center position-relative hover-effect w-100 w-md-75 w-lg-50 mx-auto">
                <!-- Ikon -->
                <img src="{{ asset('assets/icons/trophy.png') }}" height="40" alt="" class="me-3">
                <div class="d-flex flex-column">
                    <!-- Teks -->
                    Data Achievement
                </div>
                <!-- Badge jumlah -->
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                    {{ $achievementsCount }} <!-- Menampilkan jumlah Achievements -->
                    <span class="visually-hidden">unread messages</span>
                </span>
            </div>
        </a>
    </div>

      <!-- Bagian Fasilitas -->
      <div class="feature col">
        <a href="{{ route('facility.index') }}"
            class="d-flex align-items-center text-decoration-none text-dark fw-bold fs-5 w-100 p-0">
            <div
                class="bg-white p-4 border shadow-sm rounded-3 d-flex align-items-center position-relative hover-effect w-100 w-md-75 w-lg-50 mx-auto">
                <!-- Ikon -->
                <img src="{{ asset('assets/icons/facility.png') }}" height="40" alt="" class="me-3">
                <div class="d-flex flex-column">
                    <!-- Teks -->
                    Data Fasilitas
                </div>
                <!-- Badge jumlah -->
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                    {{ $facilitiesCount }} <!-- Menampilkan jumlah Achievements -->
                    <span class="visually-hidden">unread messages</span>
                </span>
            </div>
        </a>
    </div>
