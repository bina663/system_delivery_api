@extends('template.admin')

@section('title', 'Categorias')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/categories.css') }}">
@endsection

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Categorias</h2>
            <p class="text-muted mb-0">
                Gerencie as categorias da sua loja. Arraste ☰ para reorganizar a ordem.
            </p>
        </div>

        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createCategoryModal"
        >
            <i class="bi bi-plus-lg"></i>
            Nova categoria
        </button>

    </div>


    {{-- MENSAGENS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif


    {{-- ERROS --}}
    @if($errors->any())
        <div class="alert alert-danger">

            <strong>Corrija os seguintes erros:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif




    {{-- CATEGORIAS --}}
    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="40"></th>

                            <th>
                                Nome
                            </th>


                            <th>
                                Status
                            </th>

                            <th width="180">
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody id="categoriesTable">

                        @forelse($categories as $category)

                            <tr
                                class="category-row"
                                draggable="true"
                                data-id="{{ $category->id }}"
                                data-name="{{ strtolower($category->name) }}"
                                data-status="{{ $category->_status ? '1' : '0' }}"
                            >

                                {{-- DRAG --}}
                                <td class="text-muted" style="cursor: grab;">
                                    <i class="bi bi-grip-vertical fs-5 drag-handle"></i>
                                </td>

                                {{-- NOME --}}
                                <td>

                                    <strong>
                                        {{ $category->name }}
                                    </strong>

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if($category->_status)

                                        <span class="badge bg-success">
                                            Ativo
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Inativo
                                        </span>

                                    @endif

                                </td>


                                {{-- AÇÕES --}}
                                <td>

                                    <div class="d-flex gap-2">

                                        {{-- EDITAR --}}
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal{{ $category->id }}"
                                        >
                                            Editar
                                        </button>


                                        {{-- ATIVAR / DESATIVAR --}}
                                        <form
                                            class="toggle-status-form"
                                            action="{{ route('admin.categories.toggle-status', $category->id) }}"
                                            method="POST"
                                            data-confirm="Tem certeza que deseja {{ $category->_status ? 'desativar' : 'ativar' }} esta categoria?"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="_status" value="{{ $category->_status ? 0 : 1 }}">

                                            <button
                                                type="submit"
                                                class="btn btn-sm {{ $category->_status ? 'btn-danger' : 'btn-success' }}"
                                                title="{{ $category->_status ? 'Desativar' : 'Ativar' }}"
                                            >
                                               
                                                {{ $category->_status ? 'Desativar' : 'Ativar' }}
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center py-5"
                                >

                                    <div class="text-muted">

                                        <i
                                            class="bi bi-plus-circle"
                                            style="font-size:40px;"
                                        ></i>

                                        <p class="mt-2 mb-0">
                                            Nenhuma categoria cadastrada.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- SALVAR ORDEM --}}
    @if($categories->count() > 1)
        <div class="mt-3">

            <button
                type="button"
                class="btn btn-success"
                id="saveOrder"
            >
                <i class="bi bi-check-lg"></i>
                Salvar ordem
            </button>

        </div>
    @endif

</div>



{{-- ========================================================= --}}
{{-- MODAL CRIAR CATEGORIA --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="createCategoryModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                action="{{ route('admin.categories.create') }}"
                method="POST"
            >

                @csrf


                {{-- HEADER --}}
                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle"></i>
                        Criar categoria
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                {{-- BODY --}}
                <div class="modal-body">

                    <div class="row g-3">


                        {{-- NOME --}}
                        <div class="col-12">

                            <label class="form-label">
                                Nome da categoria
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Ex: Carnes, Bebidas, Sobremesas..."
                                required
                            >

                        </div>



                        {{-- STATUS --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Status
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="_status"
                                class="form-select"
                                required
                            >

                                <option value="1">
                                    Ativo
                                </option>

                                <option value="0">
                                    Inativo
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-check-lg"></i>
                        Criar categoria
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODAIS EDITAR --}}
{{-- ========================================================= --}}

@foreach($categories as $category)

<div
    class="modal fade"
    id="editCategoryModal{{ $category->id }}"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                id="editCategoryForm{{ $category->id }}"
                action="{{ route('admin.categories.update', ['id' => $category->id]) }}"
                method="POST"
            >
                @csrf
                @method('PUT')


                {{-- HEADER --}}
                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-pencil"></i>

                        Editar categoria

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                {{-- BODY --}}
                <div class="modal-body">

                    <div class="row g-3">


                        {{-- NOME --}}
                        <div class="col-12">

                            <label class="form-label">
                                Nome da categoria
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ $category->name }}"
                                required
                            >

                        </div>


                        {{-- STATUS --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Status
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="_status"
                                class="form-select"
                                required
                            >

                                <option
                                    value="1"
                                    {{ $category->_status ? 'selected' : '' }}
                                >
                                    Ativo
                                </option>

                                <option
                                    value="0"
                                    {{ !$category->_status ? 'selected' : '' }}
                                >
                                    Inativo
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </form>


            {{-- FOOTER --}}
            <div class="modal-footer d-flex justify-content-between">

                {{-- EXCLUIR PERMANENTEMENTE --}}
                <form
                    action="{{ route('admin.categories.destroy', $category->id) }}"
                    method="POST"
                    onsubmit="return confirm('Tem certeza que deseja EXCLUIR PERMANENTEMENTE esta categoria? Essa ação não pode ser desfeita.')"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-outline-danger"
                    >
                        <i class="bi bi-trash"></i>
                        Excluir permanentemente
                    </button>

                </form>


                <div class="d-flex gap-2">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        form="editCategoryForm{{ $category->id }}"
                        class="btn btn-warning"
                    >
                        <i class="bi bi-save"></i>
                        Salvar alterações
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

@endforeach

@endsection



{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchAdditional');
    const statusFilter = document.getElementById('filterStatus');

    const rows = document.querySelectorAll('.category-row');


    function filterAdditionals() {

        if (!searchInput || !statusFilter) return;

        const search = searchInput.value
            .toLowerCase()
            .trim();

        const status = statusFilter.value;


        rows.forEach(function (row) {

            const name = row.dataset.name;
            const rowStatus = row.dataset.status;


            const matchesSearch =
                name.includes(search);


            const matchesStatus =
                !status ||
                rowStatus === status;


            if (
                matchesSearch &&
                matchesStatus
            ) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    }


    if (searchInput) {
        searchInput.addEventListener('input', filterAdditionals);
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', filterAdditionals);
    }

});


/*
|--------------------------------------------------------------------------
| ATIVAR / DESATIVAR (via fetch, sem sair da página)
|--------------------------------------------------------------------------
*/
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.toggle-status-form').forEach(function (form) {

        form.addEventListener('submit', function (event) {

            event.preventDefault();

            if (!confirm(form.dataset.confirm)) {
                return;
            }

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message ?? 'Erro ao atualizar status.');
                }
            })
            .catch(function () {
                alert('Erro ao atualizar status.');
            });

        });

    });

});


/*
|--------------------------------------------------------------------------
| DRAG & DROP (ORDENAÇÃO DAS LINHAS DA TABELA)
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    const tableBody = document.getElementById('categoriesTable');
    const saveOrderBtn = document.getElementById('saveOrder');

    if (!tableBody) return;

    let draggedRow = null;


    tableBody.addEventListener('dragstart', function (event) {

        draggedRow = event.target.closest('.category-row');

        if (!draggedRow) return;

        draggedRow.classList.add('opacity-50');
    });


    tableBody.addEventListener('dragend', function () {

        if (!draggedRow) return;

        draggedRow.classList.remove('opacity-50');

        tableBody.querySelectorAll('.category-row').forEach(function (row) {
            row.classList.remove('drag-over');
        });

        draggedRow = null;
    });


    tableBody.addEventListener('dragover', function (event) {

        event.preventDefault();

        if (!draggedRow) return;

        const afterRow = getRowAfter(tableBody, event.clientY);

        tableBody.querySelectorAll('.category-row').forEach(function (row) {
            row.classList.remove('drag-over');
        });

        if (afterRow) {

            afterRow.classList.add('drag-over');

            tableBody.insertBefore(draggedRow, afterRow);

        } else {

            tableBody.appendChild(draggedRow);
        }

    });


    function getRowAfter(container, y) {

        const rows = [
            ...container.querySelectorAll('.category-row:not(.opacity-50)')
        ];

        return rows.reduce(function (closest, row) {

            const box = row.getBoundingClientRect();

            const offset = y - box.top - box.height / 2;

            if (offset < 0 && offset > closest.offset) {

                return {
                    offset: offset,
                    element: row
                };
            }

            return closest;

        }, { offset: Number.NEGATIVE_INFINITY }).element;

    }


    /*
    |----------------------------------------------------------------------
    | SALVAR ORDEM (submit tradicional, o backend redireciona)
    |----------------------------------------------------------------------
    */

    if (saveOrderBtn) {

        saveOrderBtn.addEventListener('click', function () {

            const rows = [
                ...tableBody.querySelectorAll('.category-row')
            ];

            if (!rows.length) return;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('admin.categories.order') }}";

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            rows.forEach(function (row, index) {

                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = `categories[${index}][id]`;
                idInput.value = row.dataset.id;
                form.appendChild(idInput);

                const positionInput = document.createElement('input');
                positionInput.type = 'hidden';
                positionInput.name = `categories[${index}][position]`;
                positionInput.value = index + 1;
                form.appendChild(positionInput);

            });

            document.body.appendChild(form);
            form.submit();

        });

    }

});

</script>

@endsection