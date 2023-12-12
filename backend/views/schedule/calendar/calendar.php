<?php

use hail812\adminlte3\assets\PluginAsset;
use yii\bootstrap4\Modal;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;
use yii2fullcalendar6\yii2fullcalendar6;

/* @var $events \schedule\entities\Schedule\Event\Calendar\Calendar */
/* @var $education\schedule\entities\Schedule\Event\Calendar\Calendar */

$this->title = 'Calendar';
$this->params['breadcrumbs'][] = ['label' => 'Calendar', 'url' => ['calendar']];
$this->params['breadcrumbs'][] = $this->title;
PluginAsset::register($this)->add(['sweetalert2']);

?>
<div class="row">
    <div class="col-12">
        <div id="resp"></div>
    </div>
    <div class="col">
        <div class="event-index">

            <?php
            #Регистрация переменных для использования в js коде

            Yii::$app->view->registerJs(
                "app=" . Json::encode(Yii::$app->id) . "; basePath=" . Json::encode(
                    Yii::$app->request->baseUrl
                ) . ";",
                View::POS_HEAD
            ); ?>

            <?php
            Modal::begin(
                [
                    'title' => $this->title,
                    'size' => 'SIZE_SMALL',
                    'id' => 'modal',
                    'options' => ['tabindex' => '']
                ]
            );
            Modal::end(); ?>

            <?php
            if (Yii::$app->session->hasFlash('msg')) {
                $js = "$(function (){
				var Toast = Swal.mixin({
							  toast: true,
							  position: 'top-end',
							  showConfirmButton: false,
							  timer: 5000,
							  timerProgressBar: true,
							});
							Toast.fire({
									icon: 'success',
									title: '" . Yii::$app->session->getFlash('msg') . "'
							});	  
				})
		";

                $this->registerJs($js, $position = yii\web\View::POS_READY, $key = null);
            }; ?>


            <?php

            if (Yii::$app->user->can('manager')) {
                $right = 'dayGridMonth,dayGridDay,dayGridWeek,timeGridDay,timeGridWeek';
                $editable = true;
                $initialView = 'dayGridMonth';
            } else {
                $right = 'dayGridMonth,dayGridWeek,dayGridDay,timeGridWeek,timeGridDay';
                $editable = true;
                $initialView = 'dayGridMonth';
            }
            if (Yii::$app->user->can('admin')) {
                $right = 'dayGridMonth,dayGridWeek,dayGridDay,listDay,timeGridWeek,timeGridDay';
                $initialView = 'timeGridDay';
                $nowIndicator = true;
            }

            /**
             * Triggered when a date/time selection is made
             *
             * @var  $select
             */
            $select = new JsExpression(
                "function (selectionInfo ) {
							$.ajax({
								url:'schedule/api/event-api/create',
								data:{'start':selectionInfo.startStr, 'end':selectionInfo.endStr},
								success:function (data) {
							
									$('#modal').modal('show').find('.modal-body').html(data);
							
								},
								error:function(data){
							
									var Toast = Swal.mixin({
															  toast: true,
															  position: 'top-end',
															  showConfirmButton: false,
															  timer: 5000,
															});
															  Toast.fire({
																icon: 'error',
																title: data.responseText
															  });
								},
								complete:function(data){
								
								}
							});
							
                    }"
            );


            /**
             * Triggered when resizing stops and the event has changed in duration.
             *
             * @var  $eventResize
             */
            $eventResize = new JsExpression(
                "function(event){
									var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm');
									var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm');
									var id = event.id;
									 if(app == 'app-backend'){
										$.ajax({
											url: basePath +'/calendar/event/update-resize?id='+id+'&start='+start+'&end='+end,
											type: 'POST',
											success: function(data){
											var Toast = Swal.mixin({
															  toast: true,
															  position: 'top-end',
															  showConfirmButton: false,
															  timer: 5000,
															});
															  Toast.fire({
																icon: 'info',
																title: start + ' - ' + end
															  });
												$('#calendar').fullCalendar('refetchEvents');
											},
										});
									 }
						}"
            );

            /**
             * Triggered when dragging stops and the event has moved to a different day/time.
             *
             * @var  $eventDrop
             */
            $eventDrop = new JsExpression(
                "function(event){
//									var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm');
//									var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm');
//									var id = event.id;
//									if(app == 'app-backend'){
//										$.ajax({
//											url: basePath +'/calendar/event/update-drop?id='+id+'&start='+start+'&end='+end,
//											type: 'POST',
//											success: function(){
//											var Toast = Swal.mixin({
//															  toast: true,
//															  position: 'top-end',
//															  showConfirmButton: false,
//															  timer: 5000,
//															});
//															  Toast.fire({
//																icon: 'info',
//																title: event.title+'</br>'+start + ' - ' + end
//															  });
//												$('#calendar').fullCalendar('refetchEvents');
//											},
//										});
//									 }
                		}"
            ); ?>

            <?= yii2fullcalendar6::widget(
                [
                    'id' => 'calendar',
                    'eventSources' => [
                        [
                            'events' => new JsExpression(
                                "
                                function (info, successCallback, failureCallback) {
                                    $.ajax({
                                        url: '/schedule/event/events',
                                        type: 'GET',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                                            }, success: function (response) {
                                         
                                                var event = [];
                                                 $.each(response, function( index, value ) {
                                                    event.push({
                                                        id: $(this).attr('id'),
                                                        title: $(this).attr('title'),
                                                        start: $(this).attr('start'),
                                                        end: $(this).attr('end'),
                                                        display: $(this).attr('display'),
                                                        groupId: $(this).attr('groupId'),
                                                        backgroundColor: $(this).attr('color'),
                                                        className: 'my-custom-classes',
                                                        allDay : $(this).attr('allDay'),
                                                        extendedProps:$(this).attr('extendedProps'),
                                                        url:'/schedule/api/event-api/view',
                                                        });
                                                    });
                                                   
                                                    successCallback(event)
                                                },
                                            });
                                        }"
                            )
                        ],
                        [
                            'events' => new JsExpression(
                                "
                            function (info, successCallback, failureCallback) {
                                $.ajax({
                                    url: '/schedule/education/lessons',
                                    type: 'GET',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')
                                        }, success: function (response) {
                                         
                                            var event = [];
                                             $.each(response, function( index, value ) {
                                                event.push({
                                                    id: $(this).attr('id'), 
                                                    title: $(this).attr('title'),
                                                    start: $(this).attr('start'),
                                                    end: $(this).attr('end'),
                                                    display: $(this).attr('display'),
                                                    groupId: $(this).attr('groupId'),
                                                    backgroundColor: $(this).attr('backgroundColor'),
                                                    borderColor: $(this).attr('backgroundColor'),
                                                    className: 'my-custom-classes',
                                                    allDay : $(this).attr('allDay'),
                                                    extendedProps:$(this).attr('extendedProps'),
                                                    url:'/schedule/api/education-api/view',
                                                    });
                                                });
                                                
                                                successCallback(event)
                                            },
                                        });
                                    }"
                            )
                        ]
                    ],
                    'clientOptions' => [
                        'headerToolbar' => [
                            'left' => 'prev,next,today',
                            'center' => 'title',
                            'right' => $right
                        ],
                        'themeSystem' => 'standard',
                        'expandRows' => false,
                        'stickyHeaderDates' => true,
                        'navLinks' => true,
                        'contentHeight' => 'auto',
                        'locale' => 'ru',
                        'eventOrder' => 'start',
                        //'eventMaxStack' => 3,
                        //'dayMaxEventRows'=>3,
                        'showNonCurrentDates' => false,
                        'fixedWeekCount' => false,
                        'weekNumbers' => true,
                        'weekNumberFormat' => ['week' => 'numeric'],
                        'firstDay' => 1,
                        'allDaySlot' => false,
                        'slotEventOverlap' => true,
                        'slotMinTime' => '07:00:00',
                        'slotMaxTime' => '20:00:00',
                        'slotDuration' => '0:05:00',
                        'slotLabelInterval' => '01:00:00',
                        'displayEventTime' => true,
                        'displayEventEnd' => true,
                        'buttonIcons' => [
                            'dayGridMonth' => 'fas fas fa-calendar-alt',
                            'dayGridDay' => 'far far fa-calendar-day',
                            'dayGridWeek' => 'fas fas fa-calendar-week',
                            //'listDay'=>'fas fas fa-calendar-check',
                            'timeGridDay' => 'far far fa-calendar',
                            'timeGridWeek' => 'fas fas fa-calendar-week',
                            'addEducation' => 'fas fas fa-graduation-cap'
                        ],
                        'customButtons' => [
                            'addEducation' => [
                                'text' => 'Add education event',
                                'click' => new JsExpression(
                                    "
                                    function(){
                                        $.ajax({
                                            url:'/schedule/api/education-api/create',
                                            data:{'start':new Date().toISOString().slice(0, 10), 'end':new Date().toISOString().slice(0, 10)},
                                            success:function (data) {
                                                $('#modal').modal('show').find('.modal-body').html(data);
                                            },
                                            error:function(data){
                                                var Toast = Swal.mixin({
                                                                    toast: true,
                                                                    position: 'top-end',
                                                                    showConfirmButton: false,
                                                                    timer: 5000,
                                                });
                                                Toast.fire({
                                                    icon: 'error',
                                                    title: data.responseText
                                                });
                                            },
                                        });
                                    
                                    }"
                                ),
                            ]
                        ],
                        'footerToolbar' => [
                            'right' => 'addEducation'
                        ],

                        //'selectable' => Yii::$app->user->can('manager'),
                        'selectable' => true,
                        'select' => $select,
                        'editable' => $editable,
                        'eventResize' => $eventResize,
                        'eventDrop' => $eventDrop,
                        'initialView' => $initialView,
                        'nowIndicator' => true,
                        'eventClassNames' => ['p-1', 'm-1'],
                        'viewDidMount' => new JsExpression(
                            "
                                function(info){
                                    let calendar = new FullCalendar.Calendar(document.getElementById('calendar'));
                                    var date = calendar.getDate();
                                    let a =new Intl.DateTimeFormat('default', {
                                                    dateStyle:'short',
                                                    //month: 'numeric', day: 'numeric', year:'numeric',
                                                    //hour: '2-digit', minute: '2-digit', hour24: false,
                                            }).format(new Date(date))
                                
                                    var result = a.replace(/[\.\/]/g,'-');
                                    localStorage.setItem('fcDefaultView', info.view.type);
                                    localStorage.setItem('fcDefaultViewDate', result );
                                }"
                        ),
                        //'initialDate' => 'new Date(localStorage.getItem("fcDefaultViewDate"))',
                        'windowResize' => new JsExpression(
                            "
                                function(arg) {
                                
                                  //console.log(arg);
                                   
                               }"
                        ),
                        'eventContent' => new JsExpression(
                            "function(arg){
                            
//                            Declaring variables

                                let arrayOfDomNodes = [ ];
                                
                                let startTime = new Intl.DateTimeFormat('default', {
                                            hour: '2-digit', minute: '2-digit', hour24: false,
                                        }).format(new Date(arg.event.start));
                                        
                                let endTime = new Intl.DateTimeFormat('default', {
                                               hour: '2-digit', minute: '2-digit', hour24: false,
                                        }).format(new Date(arg.event.end));
                                        
                                let wrapTitle = document.createElement('div');
                                let wrapService = document.createElement('div');
                                let wrapNotice = document.createElement('div');
                                let wrapDescription = document.createElement('div');
                                let wrapStartTime = document.createElement('span');
                                let wrapEndTime = document.createElement('span');
                                let wrapTime = document.createElement('div');
                                let wrapTeacher = document.createElement('div');
                                let wrapStudent = document.createElement('div');
                                let title = arg.event.title;
                                let service = arg.event.extendedProps.service;
                                let notice = arg.event.extendedProps.notice;
                                let start = startTime;
                                let end = ' - ' + endTime;
                                let teacher = arg.event.extendedProps.teacher;
                                let student = arg.event.extendedProps.student;
                                let description = arg.event.extendedProps.description;
                                
                                wrapTitle.classList.add('fc-event-title-container','mb-2','d-none','d-md-block','text-wrap');
                                wrapService.classList.add('fc-event-service-container','mb-2','d-none', 'd-md-block');
                                wrapNotice.classList.add('fc-event-notice-container', 'mb-2','d-none','d-md-inline','text-wrap');
                                wrapDescription.classList.add('fc-event-description-container', 'mb-2','d-none','d-md-inline','text-wrap');
                                wrapStartTime.classList.add('fc-event-time-start','dayGridMonth');
                                wrapEndTime.classList.add('fc-event-time-end', 'd-none', 'd-md-inline');
                                wrapTime.classList.add('fc-event-time-container','text-center','text-md-left');
                                wrapTeacher.classList.add('fc-event-teacher-container','mb-2','d-none','d-md-block','text-wrap');
                                wrapStudent.classList.add('fc-event-student-container','mb-2','d-none','d-md-block','text-wrap');
                                
                                wrapTitle.innerHTML = title;
                                wrapService.innerHTML = service;
                                wrapNotice.innerHTML = notice;
                                wrapDescription.innerHTML = description;
                                wrapStartTime.innerHTML = start;
                                wrapEndTime.innerHTML = end;
                                wrapTime.appendChild(wrapStartTime);
                                wrapTime.appendChild(wrapEndTime);
                                wrapTeacher.innerHTML = teacher;
                                wrapStudent.innerHTML = student;  

//                               Depending on the type of event display

                                 if(arg.view.type == 'dayGridMonth' ){
                                        arrayOfDomNodes.push(wrapTime);
                                        arrayOfDomNodes.push(wrapTitle);
                                 }
                                 if(arg.view.type == 'dayGridDay' || arg.view.type == 'timeGridDay' || arg.view.type == 'timeGridWeek'){
                                        wrapTitle.classList.remove('d-none','text-wrap');
                                        wrapTeacher.classList.remove('d-none','text-wrap');
                                        wrapStudent.classList.remove('d-none','text-wrap');
                                        wrapService.classList.remove('d-none','text-wrap');
                                        wrapNotice.classList.remove('d-none');
                                        wrapDescription.classList.remove('d-none');
                                        wrapStartTime.classList.remove('d-none','dayGridMonth');
                                        wrapEndTime.classList.remove('d-none');
                                        wrapTime.classList.remove('d-none','text-center','text-md-left');
                                        
                                    
                                        arrayOfDomNodes.push(wrapTitle);
                                       
                                        if (arg.event.groupId ==='event'){
                                            arrayOfDomNodes.push(wrapService);
                                            arrayOfDomNodes.push(wrapNotice);
                                        }
                                        if (arg.event.groupId ==='education'){
                                             arrayOfDomNodes.push(wrapTeacher);
                                             arrayOfDomNodes.push(wrapStudent);
                                             arrayOfDomNodes.push(wrapDescription);
                                        }
                                        
                                        arrayOfDomNodes.push(wrapTime);
                                 }

                                 if(arg.view.type == 'dayGridWeek'){
                                       arrayOfDomNodes.push(wrapTitle);
                                       arrayOfDomNodes.push(wrapTime);
                                 }

                                return { domNodes: arrayOfDomNodes }
                                
                                }"
                        ),
                        'dateClick' => new JsExpression(
                            "function(info){
                            
                                    $.ajax({
                                        url:'/schedule/api/event-api/create',
                                        data:{'start':info.dateStr, 'end':info.dateStr},
                                        success:function (data) {
                                            $('#modal').modal('show').find('.modal-body').html(data);
                                        },
                                        error:function(data){
                                            var Toast = Swal.mixin({
                                                                toast: true,
                                                                position: 'top-end',
                                                                showConfirmButton: false,
                                                                timer: 5000,
                                            });
                                            Toast.fire({
                                                icon: 'error',
                                                title: data.responseText
                                            });
                                        },
                                    });
                            }"
                        ),
                        'eventClick' => new JsExpression(
                            "function(info) {
                                            info.jsEvent.preventDefault(); 
                        
                                           $.ajax({
                                                url:info.event.url,
                                                data:{'id':info.event.id},
                                                success:function (data) {
                                                    $('#modal').modal('show').find('.modal-body').html(data);
                                                },
                                                error:function(data){
                                                    var Toast = Swal.mixin({
                                                                        toast: true,
                                                                        position: 'top-end',
                                                                        showConfirmButton: false,
                                                                        timer: 5000,
                                                    });
                                                    Toast.fire({
                                                        icon: 'error',
                                                        title: data.responseText
                                                    });
                                                },
                                           });
  
                            }"
                        ),
                        'eventMouseEnter'=>new JsExpression("
                                function( info  ){
                                    if(info.event.groupId ==='event'){
                                            $(info.el).tooltip({
                                                        title: info.event.title + '<br>' +  info.event.extendedProps.service,
                                                        container: 'body',
                                                        html:true,
                                                        content: info.event.extendedProps.service,
                                            });
                                    }
                                    if(info.event.groupId ==='education'){
                                        $(info.el).tooltip({
                                                        title: info.event.title + '<br>' +  info.event.extendedProps.description,
                                                        container: 'body',
                                                        html:true,
                                                        content: info.event.extendedProps.service,
                                        });
                                    }
                                    
                                }
                        
                        "),

                    ],
                ]
            ); ?>

        </div>
    </div>
</div>