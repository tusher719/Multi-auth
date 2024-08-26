@extends('admin.admin_dashboard')
@section('admin')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');

    .add-todo {
        position: fixed;
        right: 0px;
        bottom: 0px;
        font-family: 'Montserrat', sans-serif;
        /* overflow: hidden; */
    }

    .list-container {
        position: relative;
        left: 320px;
        top: 220px;
    }

    .more-button {
        background: #198754;
        box-shadow: 0px 0px 0px 4px rgba(65, 161, 251, 0.3);
        border-radius: 50%;
        width: 60px;
        height: 60px;
        border: none;
        padding: none;
        cursor: pointer;
        transition: 0.5s;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        position: relative;
        z-index: 2;
        animation: bloom infinite 1.5s;
    }

    @keyframes blooom {
        50% {
            box-shadow: 0px 0px 0px 15px rgba(92, 217, 255, 0.3);
        }
    }

    .more-button:hover {
        animation: none;
    }

    .more-button-list {
        background: #198754;
        border-radius: 10px;
        list-style: none;
        width: 450px;
        height: auto;
        padding: 15px;
        position: relative;
        right: 420px;
        bottom: 330px;
        /* opacity: 1;
        transform: scale(0); */
        transform-origin: bottom right;
        transition: all 0.2s;
    }

    .more-button-list li {
        opacity: 0;
    }

    .more-button-list li:hover {
        color: #006eff;
        background: rgb(255, 255, 255);
    }

    .menu-icon {
        width: 30px;
        height: 30px;
        border-radius: 2px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        transition: transform 0.3s ease-out;
    }

    .menu-icon-line {
        background: #fff;
        border-radius: 5px;
        width: 100%;
        height: 3px;
    }

    .menu-icon-line.half {
        width: 50%;
    }

    .menu-icon-line.first {
        transition: 0.3s;
        transform-origin: right;
    }

    .menu-icon-line.last {
        align-self: flex-end;
        transition: 0.3s;
        transform-origin: left;
    }

    /* AFTER CLICK FUNCTION */
    .list-container.active .more-button-list {
        opacity: 1;
        transform: scale(1);
    }

    /* menu button shadow animation */
    .list-container.active .more-button {
        animation: activeShadow 0.6s linear forwards;
    }

    /* menu icon animation */
    .list-container.active .menu-icon {
        transform: rotate(45deg);
    }

    .list-container.active .menu-icon-line.first {
        transform: rotate(-90deg) translateX(1px);
    }

    .list-container.active .menu-icon-line.last {
        transform: rotate(-90deg) translateX(-1px);
    }

    /* This is for button shadow animation and Menu list animation after click */
    @keyframes activeShadow {
        0% {
            box-shadow: 0px 0px 0px 0px rgba(92, 217, 255, 0.3);
        }

        50% {
            box-shadow: 0px 0px 0px 17px rgba(92, 217, 255, 0.3);
        }

        100% {
            box-shadow: 0px 0px 0px 7px rgba(92, 217, 255, 0.3);
        }
    }

    @keyframes fadeInItem {
        100% {
            transform: translateX(0px);
            opacity: 1;
        }
    }
</style>
<!-- cdn link -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Todos</li>
            <li class="breadcrumb-item active" aria-current="page">All Todos</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            @foreach ($todos as $key => $item)
            <div class="px-7">
                <strong>{{ Carbon\Carbon::parse($item->created_at)->format('d-M-Y') }}</strong> -
            </div>
            <div class="main px-7">
                    <div class="single rounded bg-white text-dark px-5 py-3 mb-3 d-flex justify-content-between">
                        <div><strong>{{ $item->name }}</strong></div> <div class="vr"></div>
                        <div>{{ $item->note }}</div> <div class="vr"></div>
                        <div>{{ Carbon\Carbon::parse($item->end_date)->format('d-M-Y') }}</div> <div class="vr"></div>

                        <div>
                                @if ($item->status == 'todo')
                                    <strong class="text-info tx-16 incomeAmount"><span>Todo</span></strong>
                                @elseif ($item->status == 'progress')
                                    <strong class="text-primary tx-16 incomeAmount"><span>Progress</span></strong>
                                @else
                                    <strong class="text-success tx-16 incomeAmount"><span>Complated</span></strong>
                                @endif
                        </div>
                        <div>

                            <div class="dropdown">
                                <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-vertical" ></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if(Auth::user()->can('admin.edit'))
                                        <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" href="{{ route('edit.todos',$item->id) }}">
                                            <i data-feather="edit-2" class="icon-sm" width="24" height="24" ></i>
                                            <span class="mx-3">Edit</span>
                                        </a>
                                    @endif
                                    @if(Auth::user()->can('admin.delete'))
                                        <a class="dropdown-item d-flex align-items-center" style="font-size: 14px;" id="delete" href="{{ route('delete.todos',$item->id) }}">
                                            <i data-feather="trash-2" class="icon-sm" width="24" height="24"></i>
                                            <span class="mx-3">Delete</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




        @endforeach
        </div>
    </div>


    <div class="add-todo">
        <div class="list-container">
            <button class="more-button">
                <div class="menu-icon">
                    <div class="menu-icon-line half first"></div>
                    <div class="menu-icon-line"></div>
                    <div class="menu-icon-line half last"></div>
                </div>
            </button>
            <ul class="more-button-list">
                <form action="{{ route('update.todos',$data->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3 d-flex justify-center align-items-center gap-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control form-control-lg" value="{{ $data->name }}" placeholder="name">
                            </div>
                            <div class="mb-3 d-flex justify-center align-items-center gap-3 text-nowrap">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control form-control-lg" value="{{ $data->end_date }}">
                            </div>
                            <div class="mb-3 d-flex justify-center align-items-center gap-3">
                                <label class="form-label">Note</label>
                                <input type="text" name="note" class="form-control form-control-lg" value="{{ $data->note }}" placeholder="Note">
                            </div>
                            <div class="mb-3 d-flex justify-center align-items-center gap-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select form-select-lg">
                                    <option selected disabled>Choose..</option>
                                    <option value="todo" {{ $data->status == 'todo' ? 'selected' : '' }}>Todo</option>
                                    <option value="progress" {{ $data->status == 'progress' ? 'selected' : '' }}>Progress</option>
                                    <option value="complated" {{ $data->status == 'complated' ? 'selected' : '' }}>Complated</option>
                                </select>
                            </div>
                            <div class="d-flex justify-center">
                                <button class="btn btn-primary" value="submit">Update Data</button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </ul>
        </div>
    </div>



</div>

<script>
    document.querySelector('.more-button').addEventListener('click', function(){
			document.querySelector('.list-container').classList.toggle('active');
		});
</script>

@endsection