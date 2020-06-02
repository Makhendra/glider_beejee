<div class="modal fade" id="questionnaire" tabindex="-1" role="dialog" aria-labelledby="questionnaire"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('questionnaire') }}" method="POST">
                <input type="hidden" name="url" value="{{url()->current()}}">
                <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Опрос</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name">Ваше ИМЯ (необязательное поле)</label>
                        <input type="text" name="name" class="form-control" id="name"/>
                    </div>
                    <div class="form-group mb-4">
                        <label for="class">Класс (необязательное поле)</label>
                        <input type="text" name="class" class="form-control" id="class"/>
                    </div>
                    <div class="form-group mb-4">
                        <label for="age">Возраст</label>
                        <input type="number" name="age" class="form-control" id="age" required/>
                    </div>
                    <div class="form-group mb-4">
                        <label for="gender">Пол</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="gender" type="radio" class="form-control"
                                   id="genderMale" value="male" required>
                            <label class="form-check-label" for="genderMale">М</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="gender" type="radio" class="form-control"
                                   id="genderFemale" value="female">
                            <label class="form-check-label" for="genderFemale">Ж</label>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="">На сколько удобен сервис?</label><br>
                        @for($i = 1; $i < 11; $i ++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="convenience" type="radio" class="form-control"
                                       id="convenience{{$i}}" value="{{$i}}" {{$i == 1 ? 'required' : ''}}>
                                <label class="form-check-label" for="convenience{{$i}}">{{$i}}</label>
                            </div>
                        @endfor
                    </div>
                    <div class="form-group mb-4">
                        <label for="task">Какое задание(номер ЕГЭ) нужно добавить в первую очередь? Или группу заданий, например "Математическая логика" или "Анализ алгоритма с циклами и условные операторы"?</label>
                        <textarea name="task" class="form-control" id="task" rows="3"></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Оцените степень понятности о том, как решать задачи.</label> <br>
                        @for($i = 1; $i < 11; $i ++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="howTo" type="radio" class="form-control"
                                       id="howTo{{$i}}" value="{{$i}}" {{$i == 1 ? 'required' : ''}}>
                                <label class="form-check-label" for="howTo{{$i}}">{{$i}}</label>
                            </div>
                        @endfor
                    </div>
                    <div class="form-group mb-4">
                        <label for="objects">Нужны ли другие предметы? Если да, то какие? К примеру математика</label>
                        <textarea name="objects" class="form-control" id="objects" rows="3"></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Оцените то как система расписывает решение заданий</label><br>
                        @for($i = 1; $i < 11; $i ++)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="solution" type="radio" class="form-control"
                                       id="solution{{$i}}" value="{{$i}}">
                                <label class="form-check-label" for="solution{{$i}}" {{$i == 1 ? 'required' : ''}}>{{$i}}</label>
                            </div>
                        @endfor
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Хотели бы вы поучаствовать в разработке?</label> <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="development" type="radio" class="form-control"
                                   id="developmentYes" value="1">
                            <label class="form-check-label" for="developmentYes">Да</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="development" type="radio" class="form-control"
                                   id="developmentNot" value="0">
                            <label class="form-check-label" for="developmentNot">Нет</label>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="wishes_and_criticism">Поле для общих пожеланий и критики:</label>
                        <textarea name="wishes_and_criticism" class="form-control" id="wishes_and_criticism"
                                  rows="3"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Отправить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
                </div>
            </form>
        </div>
    </div>
</div>