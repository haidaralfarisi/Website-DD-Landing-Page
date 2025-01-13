<div class="row row-cols-1 row-cols-lg-6 mb-3">
    <div class="feature col">
        <div class="bg-white p-2 border shadow-sm rounded-3 d-flex align-items-center position-relative">
            <img src="{{ asset('assets/icons/ic-gear.png') }}" height="20" alt="" class="me-2">
            <a href="{{ route('admin.posts.index') }}" class="text-decoration-none text-dark fw-bold">Data Post (Admin)</a>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                0
                <span class="visually-hidden">unread messages</span>
            </span>
        </div>
    </div>


    {{-- <div class="feature col">
        <div class="bg-white p-2 border shadow-sm rounded-3 d-flex align-items-center position-relative">
            <img src="{{ asset('assets/icons/ic-gear.png') }}" height="20" alt="" class="me-2">
            <a href="{{ route('admin.unit') }}" class="text-decoration-none text-dark fw-bold">Unit</a>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                {{ count($data_unit) }}
                <span class="visually-hidden">unread messages</span>
            </span>
        </div>
    </div>
    <div class="feature col">
        <div class="bg-white p-2 border shadow-sm rounded-3 d-flex align-items-center position-relative">
            <img src="{{ asset('assets/icons/ic-gear.png') }}" height="20" alt="" class="me-2">
            <a href="{{ route('admin.jabatan') }}" class="text-decoration-none text-dark fw-bold">Jabatan</a>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                {{ count($data_jabatan) }}
                <span class="visually-hidden">unread messages</span>
            </span>
        </div>
    </div>

    <div class="feature col">
        <div class="bg-white p-2 border shadow-sm rounded-3 d-flex align-items-center position-relative">
            <img src="{{ asset('assets/icons/ic-gear.png') }}" height="20" alt="" class="me-2">
            <a href="{{ route('admin.indikator') }}" class="text-decoration-none text-dark fw-bold">Indikator</a>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                {{ count($data_indikator) }}
                <span class="visually-hidden">unread messages</span>
            </span>
        </div>
    </div>

    <div class="feature col">
        <div class="bg-white p-2 border shadow-sm rounded-3 d-flex align-items-center position-relative">
            <img src="{{ asset('assets/icons/ic-gear.png') }}" height="20" alt="" class="me-2">
            <a href="{{ route('admin.komponen') }}" class="text-decoration-none text-dark fw-bold">Komponen</a>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                {{ count($data_komponen) }}
                <span class="visually-hidden">unread messages</span>
            </span>
        </div>
    </div>
    <div class="feature col">
        <div class="bg-white p-2 border shadow-sm rounded-3 d-flex align-items-center position-relative">
            <img src="{{ asset('assets/icons/ic-gear.png') }}" height="20" alt="" class="me-2">
            <a href="{{ route('admin.employee') }}" class="text-decoration-none text-dark fw-bold">Employees</a>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                {{ count($data_employee) }}
                <span class="visually-hidden">unread messages</span>
            </span>
        </div>
    </div> --}}

</div>
