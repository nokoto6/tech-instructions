@php
    use App\Models\User;
@endphp

@extends("body")

@section("content")
    <a class="simple-input simple-input__button simple-input__link" href="{{url()->previous("/foo")}}">Назад</a>

    <div class="item_view-container">
        <h1>Инструкция для {{ $item->item_name }}</h1>

        <div>
            <b><span>Описание: </span></b>
            <div class="description-show">{{ $item->description }}</div>
        </div>

        <div>
            <b><span>Выложил: </span></b>
            <span>{{ User::where(['id' => $item->uploader_id])->first()->name }}</span>
        </div>
        
        <iframe class="item_view-iframe" src="{{ $item['file'] }}" height="800px" width="550px" seamless></iframe>

        <a class="simple-input simple-input__button simple-input__link" href="{{ $item['file'] }}" target=”_blank” type="submit">Открыть файл в новой вкладке</a>
        <a class="simple-input simple-input__button simple-input__link" href="{{ $item['file'] }}" download type="submit">Скачать файл</a>
        <button class="simple-input simple-input__button simple-input__link simple-input__red" id="modalOpen">Пожаловаться</button>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Отправить жалобу</h1>
            <form 
                method="POST" 
                action="{{ route('complaint-create', ['instruction_id'=>$item->id]) }}"
            >
                @csrf
                <textarea class="simple-input simple-input__fillable simple-input__area" maxlength="255" name="description" placeholder="Описание" required></textarea>
                <div class="auth-border"></div>
                <button class="simple-input simple-input__button" type="submit">Отправить</button>
            </form>
        </div>
    </div>

    <script>
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("modalOpen");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
@endsection