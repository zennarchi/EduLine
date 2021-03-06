@extends('layout')

@section('content')

    <main role="main">

        <section class="jumbotron text-left">
            <style type="text/css">
                .jumbotron {
                    background: url({{$course->courseBg()}});
                    height: 300px;
                    border-radius:0;
                }
            </style>

            <div class="container">
                <h1 class="jumbotron-heading text-light">{{$course->title}}</h1>
                <p class="lead text-light">{{$course->short_description}}</p>
                <div class="row">
                    <div class="col-sm-2">
                        <p class="text-light">Автор: <a class="text-light" href="{{route('teacher_courses.index', $course->author->id)}}">{{$course->author->name}}</a></p>
                    </div>
                    <div class="col-sm-3 text-left">
                        <p class="text-light">Зареєстрованих студентів: {{$course->countStudents()}}</p>
                    </div>
                </div>

            </div>
        </section>


        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="word-list">
                        <div class="row">
                            <div class="col-md-3 course-buy d-block d-md-none mt-2">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="videoContainer">
                                <img align="center" class="img-fluid" src="{{$course->getImage()}}">
                                <a href="#" data-toggle="modal" data-target="#exampleModal"><img src="/img/play.png" alt="play" class="playBtn"></a>
                            </div>
                            <h4 align="center">{{$course->title}}</h4>
                            <h3 align="center">{{$course->price}}$</h3>

                            @if(Auth::check())
                                @if($course->checkPay(Auth::user()->id) || $course->checkTeacher() == true)
                                    <a href="{{route('course.lessons', [$course->id, 0])}}"><input type="submit" class="btn btn-warning btn-block" value="Перейти до перегляду" ></a>
                                @else
                                    <form id="payment" name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8">
                                        <input type="hidden" name="ik_co_id" value="5aa84a6c3b1eaf55298b4570">
                                        <input type="hidden" name="ik_pm_no" value="{{time()}}">
                                        <input type="hidden" name="ik_am" value="{{$course->price}}">
                                        <input type="hidden" name="ik_cur" value="UAH">
                                        <input type="hidden" name="ik_x_login" value="{{Auth::user()->id}}">
                                        <input type="hidden" name="ik_x_course" value="{{$course->id}}">
                                        <input type="hidden" name="ik_desc" value="Продажа курсу">
                                        <input type="submit" class="btn btn-warning btn-block" value="Купити">
                                    </form>
                                @endif

                            @else
                                <a href="/login"><input type="submit" class="btn btn-warning btn-block" value="Купити"></a>
                            @endif
                            <button type="button" class="btn btn-outline-primary btn-block mt-3" data-toggle="modal" data-target="#exampleModal">Спробувати</button>
                        </div>
                    </div>
                </div>
                            @if($course->requirements != null)
                            <div class="col-md-12 new-skills">
                                <h4 class="text-muted">Чому я научусь ?</h4>
                                <p class="text-muted">{{$course->skills}}</p>
                            </div>
                            @endif
                            @if($course->requirements != null)
                            <div class="col-md-9 requirements">
                                <h4 class="text-muted">Вимоги</h4>
                                <ul class="list-group">
                                    <div class="list-group-item">{{$course->requirements}}</div>
                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12 description">
                                <h4 class="text-muted">Опис</h4>
                                <p class="text-left">{{$course->description}}</p>
                            </div>

                            <div class="col-md-12 compare d-none d-md-block">


                                <div class="row">
                                    @if($relates->count() >= 1)
                                    <h4 class="text-muted">Порівняти зі схожими курсами</h4>
                                    <div class="col-md-12 comparison">
                                        @foreach($relates as $relate)
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img onclick="window.location.href='{{route('course.index', $relate->id)}}'" class="img-fluid related-course-img" height="25" src="{{$relate->getImage()}}">
                                            </div>
                                            <div class="col-md-5">
                                                <h4 class="text-muted font-weight-light related-course-info"><a href="{{route('course.index', $relate->id)}}">{{$relate->title}}</a></h4>
                                                <p class="text-muted">Автор: {{$relate->author->name}}</p>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="users-count">
                                                    <i class="fa fa-users text-muted" aria-hidden="true"></i> {{$relate->countStudents()}}
                                                </div>

                                            </div>
                                            <div class="col-md-3 text-center related-course-info">
                                                <h5 class="font-weight-light">{{$relate->price}} грн.</h5>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            
                            <div class="col-md-12 about-teacher">
                                <div  class="teacher-info justify-content-center text-center">
                                    <p align="center" class="text-muted small-head-text">Про викладача</p>
                                    <a href="{{route('teacher_courses.index', $course->author->id)}}">{{$course->author->name}}</a>
                                    <p><small class="text-muted">Вчитель на EduLine</small></p>
                                    <img width="100" height="100" class="rounded-circle" src="{{$teacher->getImage()}}">
                                </div>
                                <div class="col-md-12">
                                    <div class="text-center">

                                            <li><i class="fa fa-user fa-black" aria-hidden="true"></i> {{$course->countStudents()}} студентів</li>

                                    </div>
                                    <p>{{$course->author->short_description}}</p>
                                    <p>{{$course->author->description}}</p>
                                </div>

                            </div>
                            <h3 align="center" class="text-muted reviews-title">Відгуки студентів</h3>
                            @if(Auth::check())
                            <div class="course-reviews">
                                <div class="row">
                                    <div class="col-md-11 mt-3 ml-3">
                                        <form action="/comment" method="post" role="form">
                                            {{csrf_field()}}
                                            <input type="hidden" name="course_id" value="{{$course->id}}">
                                            <textarea name="course_review" class="form-control course-review-area" rows="5"></textarea>
                                            <button type="submit" class="btn btn-primary mt-2 mb-3">Залишити коментар</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(!$course->comments->isEmpty())
                            @foreach($course->comments as $comment)
                            <div class="course-reviews mt-2 mb-2">

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="course-review-info">
                                            <img src="/img/student.png">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="text-left review-author">{{$comment->author->name}}</p>
                                    </div>
                                    <div class="col-md-7 review-text">
                                        <p>{{$comment->text}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                                <div class="course-reviews mt-2 pt-3 pb-3 mb-4 text-center">
                                    <strong class="text-muted">Ще немає коментарів...</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-md-3 course-buy d-none d-md-block">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="videoContainer">
                                <img align="center" class="img-fluid" src="{{$course->getImage()}}">
                                <a href="#" data-toggle="modal" data-target="#exampleModal"><img src="/img/play.png" alt="play" class="playBtn"></a>
                            </div>
                            <h4 align="center" class="font-weight-light">{{$course->title}}</h4>
                            <h3 align="center" class="font-weight-light">{{$course->price}} грн.</h3>

                            @if(Auth::check())
                                @if($course->checkPay(Auth::user()->id) || $course->checkTeacher() == true)
                                    <a href="{{route('course.lessons', [$course->id, 0])}}"><input type="submit" class="btn btn-warning btn-block" value="Перейти до перегляду" ></a>
                                @else
                                    <form id="payment" name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8">
                                        <input type="hidden" name="ik_co_id" value="5aa84a6c3b1eaf55298b4570">
                                        <input type="hidden" name="ik_pm_no" value="{{time()}}">
                                        <input type="hidden" name="ik_am" value="{{$course->price}}">
                                        <input type="hidden" name="ik_cur" value="UAH">
                                        <input type="hidden" name="ik_x_login" value="{{Auth::user()->id}}">
                                        <input type="hidden" name="ik_x_course" value="{{$course->id}}">
                                        <input type="hidden" name="ik_desc" value="Продажа курсу">
                                        <input type="submit" class="btn btn-warning btn-block" value="Купити">
                                    </form>
                                @endif

                            @else
                                <a href="/login"><input type="submit" class="btn btn-warning btn-block" value="Купити"></a>
                            @endif
                            <button type="button" class="btn btn-outline-primary btn-block mt-3" data-toggle="modal" data-target="#exampleModal">Спробувати</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Презентація курсу</h5>
                    <button type="button" onclick="stopVideo()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body1">
                        <video class="video-js w-100" controls
                               poster="{{$course->getImage()}}" data-setup="{}">
                            <source id="video-source" src="{{$course->getDemo()}}" type="video/mp4">
                        </video>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" onclick="stopVideo()" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        function stopVideo(){
            $(".video-js")[0].player.pause();
        }

    </script>

@endsection