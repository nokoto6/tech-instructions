
<div class="main-container">
    <h1 class="main-title">Главная</h1>

    <div class="cute-border__template general-container">
        <h2 class="general-title">Сайт по поиску инструкций для техники!</h2>
        
        <span class="material-symbols-rounded general-image">
            auto_stories
        </span>

        <span class="general-text">
            Мы помогаем Вам легко находить инструкции для вашей техники. 
        </span>
    </div>

    <div class="cute-border__template general-container">
        <span class="general-text">
            Просто введите название устройства в поиске:
        </span>

        <a class="cute-button-link" href="{{route('results')}}">Перейти к поиску инструкций</a>
    </div>

    <div class="cute-border__template general-container">
        <span class="general-text">
            Или выберите категорию:
        </span>

        <a class="cute-button-link" href="{{route('categories')}}">Выбор категории</a>

        <span class="general-text">
            И найдите нужные материалы всего за несколько кликов!
        </span>
    </div>

    <div class="cute-border__template general-container">
        <span class="general-text">
            Также Вы можете помочь проекту и добавить собственную инструкцию:
        </span>

        <a class="cute-button-link" href="{{route('instruction-form')}}">Добавить инструкцию</a>
    </div>
</div>

<script src="/js/search.js"></script>
