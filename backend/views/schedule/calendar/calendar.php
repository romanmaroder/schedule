<?php

use hail812\adminlte3\assets\PluginAsset;
use yii\bootstrap4\Modal;
use yii\web\JsExpression;
use yii2fullcalendar6\yii2fullcalendar6;

/* @var $events \core\entities\Schedule\Event\Calendar\Calendar */
/* @var $education \core\entities\Schedule\Event\Calendar\Calendar */

$this->title = 'Calendar';
$this->params['breadcrumbs'][] = ['label' => 'Calendar', 'url' => ['calendar']];
$this->params['breadcrumbs'][] = $this->title;
PluginAsset::register($this)->add(['sweetalert2']);


?>


<div class="row">
    <div class="col-12">
        <div id="resp"></div>
    </div>
    <div class="col-12">
        <div class="event-index">

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
								url:'/schedule/api/event-api/create',
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
                "function(eventResizeInfo ){
									$.ajax({
                                         url:'/schedule/api/'+ eventResizeInfo.event.source.id +'-api/dragging-resizing',
                                         data:{'id':eventResizeInfo.event.id,'start':eventResizeInfo.event.startStr,'end':eventResizeInfo.event.endStr},
                                         success:function (data) {
                                                    var Toast = Swal.mixin({
                                                                        toast: true,
                                                                        position: 'top-end',
                                                                        showConfirmButton: false,
                                                                        timer: 5000,
                                                    });
                                                    Toast.fire({
                                                        icon: 'success',
                                                        title: `<h6>Event changed</h6>`,
                                                        html:`<i> start: `+ data.start +`</i>` + `</br>` + `<i> end: ` + data.end + `</i>`,
                                                    });
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
            );

            /**
             * Triggered when dragging stops and the event has moved to a different day/time.
             *
             * @var  $eventDrop
             */
            $eventDrop = new JsExpression(
                "function(eventDropInfo ){
                                            $.ajax({
                                                url:'/schedule/api/'+ eventDropInfo.event.source.id +'-api/dragging-resizing',
                                                data:{'id':eventDropInfo.event.id,'start':eventDropInfo.event.startStr,'end':eventDropInfo.event.endStr},
                                                success:function (data) {
                                                    var Toast = Swal.mixin({
                                                                        toast: true,
                                                                        position: 'top-end',
                                                                        showConfirmButton: false,
                                                                        timer: 5000,
                                                    });
                                                    Toast.fire({
                                                        icon: 'success',
                                                        title: `<h6>The event has been moved to</h6>`,
                                                        html:`<i> start: `+ data.start +`</i>` + `</br>` + `<i> end: ` + data.end + `</i>`,
                                                    });
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
            );
            ?>

            <?= yii2fullcalendar6::widget(
                [
                    'id' => 'calendar',
                    'eventSources' => [
                        [
                            'id' => 'event',
                            'title' => 'Event',
                            'className' => 'event-class',
                            'backgroundColor'=>'#004794',
                            'textColor'=>'#F5FCFF',
                            'events' => new JsExpression(
                                "
                                function (info, successCallback, failureCallback) {
                                    $.ajax({
                                        url: '/schedule/event/events',
                                        type: 'GET',
                                        crossDomain: true,
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
                                                        source: $(this).attr('source'),
                                                        backgroundColor: $(this).attr('backgroundColor'),
                                                        borderColor: $(this).attr('backgroundColor'),
                                                        className: 'event-custom-classes',
                                                        allDay : $(this).attr('allDay'),
                                                        groupId : $(this).attr('groupId'),
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
                            'id' => 'education',
                            'title' => 'Education',
                            'className' => 'education-class',
                            'backgroundColor'=>'#51560B',
                            'textColor'=>'#F5F5F5',
                            'events' => new JsExpression(
                                "
                                function (info, successCallback, failureCallback) {
                                    $.ajax({
                                        url: '/schedule/education/lessons',
                                        type: 'GET',
                                        crossDomain: true,
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
                                                        source: $(this).attr('source'),
                                                        backgroundColor: $(this).attr('backgroundColor'),
                                                        borderColor: $(this).attr('backgroundColor'),
                                                        className: 'education-custom-classes',
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
                        'themeSystem' => 'standard',
                        'headerToolbar' => [
                            'left' => 'prev,next,today',
                            'center' => 'title',
                            'right' => 'dayGridMonth,dayGridWeek,dayGridDay,timeGridDay' //TODO timeGridWeek think about displaying
                        ],
                        'footerToolbar' => [
                            'right' => 'addEducation'
                        ],
                        'initialView' =>  new JsExpression(
                            "
             localStorage.getItem('fullCalendarDefaultView') !== null ? localStorage.getItem('fullCalendarDefaultView') : '$initialView'"),
                        'selectable' => true,
                        'editable' => true,
                        'select' => $select,
                        'eventResize' => $eventResize,
                        'eventDrop' => $eventDrop,
                        'droppable' => true,
                        'nowIndicator' => true,
                        'expandRows' => false,
                        'stickyHeaderDates' => true,
                        'navLinks' => true,
                        'contentHeight' => 'auto',
                        'locale' => 'ru',
                        'eventOrder' => 'start',
                        //'eventMaxStack' => 5,
                        'dayMaxEventRows'=>7,
                        'dayMaxEvents'=> false,
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
                        'filterResourcesWithEvents'=>true,
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
                        'eventClassNames' => ['p-1', 'm-1'],
                        'eventDidMount' => new JsExpression(
                            "
                                function(info){

                                }"
                        ),
                        'windowResize' => new JsExpression(
                            "
                                function(arg) {
                                
                                   
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
                                let start = '&nbsp;' + startTime + '&nbsp;';
                                let end = '&nbsp;' + endTime + '&nbsp;';
                                let teacher = arg.event.extendedProps.teacher;
                                let student = arg.event.extendedProps.student;
                                let description = arg.event.extendedProps.description;
                                
                                wrapTitle.classList.add('fc-event-title-container','mb-2','d-none','d-md-block','text-wrap');
                                wrapService.classList.add('fc-event-service-container','mb-2','d-none', 'd-md-block');
                                wrapNotice.classList.add('fc-event-notice-container', 'mb-2','d-none','d-md-inline','text-wrap');
                                wrapDescription.classList.add('fc-event-description-container', 'mb-2','d-none','d-md-inline','text-wrap');
                                wrapStartTime.classList.add('fc-event-time-start','dayGridMonth');
                                wrapEndTime.classList.add('fc-event-time-end','dayGridMonth');
                                wrapTime.classList.add('fc-event-time-container','text-center','text-md-left','d-flex','flex-column','flex-sm-row');
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
                                        wrapEndTime.classList.remove('d-none','dayGridMonth');
                                        wrapTime.classList.remove('d-none','text-center','text-md-left','flex-column');
                                        
                                    
                                        arrayOfDomNodes.push(wrapTitle);
                                       
                                        if (arg.event.source.id ==='event'){
                                            arrayOfDomNodes.push(wrapService);
                                            arrayOfDomNodes.push(wrapNotice);
                                        }
                                        if (arg.event.source.id ==='education'){
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
                                            $('#modal').modal('show').find('#modal-label').html(info.view.title);
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
                                                    $('#modal').modal('show').find('#modal-label').html(info.event.title);
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
                        'eventMouseEnter' => new JsExpression(
                            "
                                function( info  ){
                                    if(info.event.source.id ==='event'){
                                            $(info.el).tooltip({
                                                        title: info.event.title + '<br>' +  info.event.extendedProps.service,
                                                        container: 'body',
                                                        html:true,
                                                        content: info.event.extendedProps.service,
                                            });
                                    }
                                    if(info.event.source.id ==='education'){
                                        $(info.el).tooltip({
                                                        title: info.event.title + '<br>' +  info.event.extendedProps.description,
                                                        container: 'body',
                                                        html:true,
                                                        content: info.event.extendedProps.service,
                                        });
                                    }
                                    
                                }
                        
                        "
                        ),
                        'initialDate' => new JsExpression('new Date(localStorage.getItem("fullCalendarDefaultDate"))'),
                        'datesSet' => new JsExpression(
                            "function( dateInfo)
                                        {
                                        var date = new Date(dateInfo.view.currentStart);
                                            var date = new Date(dateInfo.view.currentStart);
                                            var view = dateInfo.view.type;

                                            dateObj = new Date(date) 
                                            dateIntNTZ = dateObj.getTime() - dateObj.getTimezoneOffset() * 60 * 1000
                                            dateObjNTZ = new Date(dateIntNTZ)
                                            
                                            localStorage.fullCalendarDefaultDate =  dateObjNTZ.toISOString().slice(0, 10)
                                            
                                            localStorage.fullCalendarDefaultView = view;
                                        }"
                        ),

                    ],
                ]
            ); ?>

        </div>
    </div>
</div>
