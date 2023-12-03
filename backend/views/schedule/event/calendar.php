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
								url:'/schedule/event/create-ajax',
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
                    'eventSources' => [$events, $education],
                    'clientOptions' => [
                        'headerToolbar' => [
                            'left' => 'prev,next,today',
                            'center' => 'title',
                            'right' => $right
                        ],
                        'themeSystem' => 'standard',
                        'expandRows' => false,
                        'stickyHeaderDates'=>true,
                        'navLinks' => true,
                        'contentHeight' => 'auto',
                        'locale' => 'ru',
                        'eventOrder' => 'start',
                        //'eventMaxStack' => 3,
                        //'dayMaxEventRows'=>3,
                        'showNonCurrentDates' => false,
                        'fixedWeekCount' => false,
                        'weekNumbers'=>true,
                        'weekNumberFormat'=>['week'=>'numeric'],
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
                                    alert('clicked the custom button!');}"
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
                                
                                  console.log(arg);
                                   
                               }"
                        ),
                        'eventContent' => new JsExpression(
                            "function(arg){
                              
                                let startTime = new Intl.DateTimeFormat('default', {
                                                //month: 'short', day: 'numeric',
                                                hour: '2-digit', minute: '2-digit', hour24: false,
                                        }).format(new Date(arg.event.start));
                                        
                                 let endTime = new Intl.DateTimeFormat('default', {
                                                //month: 'short', day: 'numeric',
                                                hour: '2-digit', minute: '2-digit', hour24: false,
                                        }).format(new Date(arg.event.end));
                                        
                                let wrapTitle = document.createElement('div');
                                let wrapService = document.createElement('div');
                                let wrapDescription = document.createElement('div');
                                let wrapStartTime = document.createElement('span');
                                let wrapEndTime = document.createElement('span');
                                let wrapTime = document.createElement('div');
                                
                                wrapTitle.classList.add('fc-event-title-container','mb-2','d-none','d-md-block','text-wrap');
                                wrapService.classList.add('fc-event-service-container','mb-2','d-none', 'd-md-block');
                                wrapDescription.classList.add('fc-event-description-container', 'mb-2','d-none','d-md-inline','text-wrap');
                                wrapStartTime.classList.add('fc-event-time-start','dayGridMonth');
                                wrapEndTime.classList.add('fc-event-time-end', 'd-none', 'd-md-inline');
                                wrapTime.classList.add('fc-event-time-container','text-center','text-md-left');
                                
                                let title = arg.event.title ? arg.event.title : arg.event.id;
                                let service = arg.event.extendedProps.service;
                                let description = arg.event.extendedProps.description ? arg.event.extendedProps.description :
                                        arg.event.extendedProps.notice;
                                 let start = startTime;
                                 let end = ' - ' + endTime;
                                 
                                
                                
                                wrapTitle.innerHTML=title;
                                wrapService.innerHTML=service;
                                wrapDescription.innerHTML=description;
                                wrapStartTime.innerHTML = start;
                                wrapEndTime.innerHTML = end;
                                wrapTime.appendChild(wrapStartTime);
                                wrapTime.appendChild(wrapEndTime);
                                
                                
                                let arrayOfDomNodes = [ ];
                               
                                
                                 if(arg.view.type == 'dayGridMonth' ){
                                        arrayOfDomNodes.push(wrapTime);
                                        arrayOfDomNodes.push(wrapTitle);
                                 }
                                 
                                 if(arg.view.type == 'dayGridDay' || arg.view.type == 'timeGridDay' || arg.view.type == 'timeGridWeek'){
                                        wrapTitle.classList.remove('d-none','text-wrap');
                                        wrapService.classList.remove('d-none','text-wrap');
                                        wrapDescription.classList.remove('d-none','text-wrap');
                                        wrapStartTime.classList.remove('d-none','dayGridMonth');
                                        wrapEndTime.classList.remove('d-none');
                                        wrapTime.classList.remove('d-none','text-center','text-md-left');
                                        arrayOfDomNodes.push(wrapTitle);
                                        arrayOfDomNodes.push(wrapService);
                                        arrayOfDomNodes.push(wrapDescription);
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
								url:'/schedule/event/create-ajax',
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
								        url:'/schedule/event/view-ajax',
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
                                    $(info.el).tooltip({
                                                    title: info.event.title + '<br>' +  info.event.extendedProps.service,
                                                    container: 'body',
                                                    html:true,
                                                    content: info.event.extendedProps.service,
                                    });
                                }
                        
                        "),

                    ],
                ]
            ); ?>
            <!--                --><?
            //= yii2fullcalendar::widget(
            //                    [
            //                        'id' => 'calendar',
            //                        'themeSystem' => 'bootstrap4',
            //                        'events' => $events,
            //                        /*'defaultView' => new JsExpression(
            //                            "
            //             localStorage.getItem('fcDefaultView') !== null ? localStorage.getItem('fcDefaultView') : 'dayGridDay'
            //            "
            //                        ),*/
            //
            //                        'headerToolbar' => [
            //                            'left' => 'prev,next,today',
            //                            'center' => 'title',
            //                            'right' => $right
            //                        ],
            //                        'clientOptions' => [
            //                            // 'eventOverlap ' => false,
            //                            // 'todayBtn' => true,
            //                            'themeSystem' => 'bootstrap4',
            //                            'navLinks' => true,
            //                            'contentHeight' => 'auto',
            //                            //'timeFormat' => 'H:mm',
            //                            'locale' => 'ru',
            //                            // 'eventLimit' => false,
            //                            'eventOrder' => '-title',
            //                            'buttonText' => [
            //                                'GridWeek' => 'Повестка недели',
            //                                //'agendaDay' => 'День-Время',
            //                                //'agendaWeek' => 'Неделя-Время'
            //                            ],
            //                            'views' => [
            //                                'dayGridMonth' => [
            //                                    //'eventLimit' => 10,
            //                                    'displayEventTime' => true, // отображение времени в месяце
            //                                ],
            //                                'dayGrid' => [
            //                                    'displayEventTime' => true, // отображение времени в месяце
            //                                ],
            //                                'day' => [
            //                                    //'eventLimit' => 15,
            //                                ],
            //                                'GridWeek' => [
            //                                    // 'eventLimit' => false,
            //                                    'displayEventTime' => false
            //                                ]
            //                            ],
            //                            // 'eventLimitClick' => 'popover',
            //                            //'theme' => true,
            //                            'fixedWeekCount' => false,
            //                            'allDaySlot' => false,
            //                            //'allDayText'=>false,
            //                            'slotEventOverlap' => true,
            //                            //'agendaEventMinHeight' => 100,
            //                            'slotDuration' => '0:15:00',
            //                            'slotLabelInterval' => '01:00:00',
            //                            'slotLabelFormat' => 'HH:mm',
            //                            //'minTime' => '07:00:00',
            //                            //'maxTime' => '22:00:00',
            //                            'selectable' => Yii::$app->user->can('manager'),
            //                            // 'selectHelper' => true,
            //                            'select' => $select,
            //                            'editable' => $editable,
            //                            'eventResize' => $eventResize,
            //                            'eventDrop' => $eventDrop,
            //                            'initialView' => $initialView,
            //                            'nowIndicator' => $nowIndicator,
            //                            /*'defaultDate' => new JsExpression(
            //                                "
            //                localStorage.getItem('fcDefaultViewDate') !==null ? localStorage.getItem('fcDefaultViewDate') : $('#calendar').fullCalendar('getDate')
            //                "
            //                            ),*/
            //                            'windowResize' => $window_resize,
            //
            //                            'eventClick' => new JsExpression(
            //                                "function(event) {
            //
            //                     if(app == 'app-backend'){
            //                        viewUrl = basePath +'/calendar/event/view?id=' + event.id;
            //                        updateUrl = basePath +'/calendar/event/update?id=' + event.id;
            //                         $('#edit-link').attr('href', updateUrl);
            //                     }else{
            //                        viewUrl = '/calendar/event/view?id=' + event.id;
            //                        //updateUrl = '/calendar/event/update?id=' + event.id;
            //                     }
            //
            //                      $('.popover').remove();
            //                      $('#modal').find('.modal-body').load(viewUrl);
            //                      $('#modal').modal('show');
            //                    }"
            //                            ),
            //                            /*'dayRender' => new JsExpression(
            //                                "function(cell,date){
            //
            //                    } "
            //                            ),*/
            //                            /*'eventRender' => new JsExpression(
            //                                "function (event, element, view){
            //                                    $('.popover').remove();
            //                                    element.addClass('event-render');
            //                                    element.find('.fc-content').append( element.find('.fc-time').addClass('font-italic') );
            //
            //                                    if (view.name == 'dayGridDay' ) {
            //                                        element.find('.fc-content').addClass('d-flex flex-column');
            //                                        element.addClass('fc-basic_day');
            //                                        element.find('.fc-title').addClass('font-weight-bold pb-2').after('<span class=\"fc-description pb-2\"><i>' + event.nonstandard.description + '</i></span>');
            //                                        if( event.nonstandard.notice){
            //                                            element.find('.fc-description').after('<span class=\"fc-notice pb-2\"><u><i>' + event.nonstandard.notice + '</i></u></span>');
            //                                        }
            //                                    }
            //                                     if (view.name == 'month' ) {
            //                                        element.addClass('fc-basic_month');
            //                                        element.find('.fc-content').prepend(element.find('.fc-time'));
            //
            //                                        if(event.title === 'Свободное время'){
            //                                            element.find('.fc-title').addClass('free-time');
            //                                            element.find('.fc-time').addClass('free-time');
            //                                        }
            //
            //                                        element.find('.fc-content').find('.fc-time').css({'white-space':'break-spaces'});
            //                                        element.find('.fc-content').find('.fc-title').addClass('d-none d-sm-block').css({'float':'none'});
            //
            //                                        if( $('.fc-basic_month').closest('div').length > 0 ){
            //                                            element.find('.fc-content').find('.fc-title').removeClass('d-none').addClass('d-inline-block');
            //                                            element.addClass('w-100');
            //                                        }
            //
            //                                         element.popover({
            //                                                placement: 'top',
            //                                                html: true,
            //                                                image: true,
            //                                                trigger : 'hover',
            //                                                title: event.title,
            //                                                content: event.nonstandard.description ? event.nonstandard.description : '',
            //                                                container:'body'
            //                                        });
            //                                     }
            //                                     if ( view.name == 'GridWeek' ){
            //                                        let pop =  element.popover({
            //                                                placement: 'top',
            //                                                html: true,
            //                                                image: true,
            //                                                trigger : 'hover',
            //                                                title: event.title + ' ' + event.start.format('HH:mm'),
            //                                                content: event.nonstandard.description ? event.nonstandard.description : '',
            //                                                container:'body',
            //
            //                                        });
            //                                        if(event.title === 'Свободное время'){
            //                                            element.find('.fc-title').addClass('free-time');
            //                                        }
            //                                     }
            //                                     if ( view.name == 'GridWeek' ) {
            //                                        element.find('.fc-list-item-marker ').append(' (' + event.nonstandard.master_name + ') ');
            //                                     }
            //                                      if (view.name == 'listWeek') {
            //
            //                                          element.find('.fc-title').addClass('font-weight-bold pb-2').after('<span class=\"fc-description pb-2\"><i>' + event.nonstandard.description + '</i></span>');
            //                                            if( event.nonstandard.notice){
            //                                                element.find('.fc-description').after('<span class=\"fc-notice pb-2\"><u><i>' + event.nonstandard.notice + '</i></u></span>');
            //                                            }
            //                                      }
            //                                      if ( view.name == 'listDay') {
            //
            //                                          element.find('.fc-title').addClass('font-weight-bold pb-2').after('<span class=\"fc-description pb-2\"><i>' + event.nonstandard.description + '</i></span>');
            //                                            if( event.nonstandard.notice){
            //                                                element.find('.fc-description').after('</br><span class=\"fc-notice pb-2\"><u><i>' + event.nonstandard.notice + '</i></u></span>');
            //                                            }
            //                                      }
            //
            //                  				}"
            //                            ),*/
            //                            /*'eventAfterAllRender' => new JsExpression(
            //                                "
            //                	function(view){
            //						view.calendar.el.find('.fc-right').find('.btn-group-vertical').removeClass('btn-group-vertical').addClass('btn-group');
            //						if ($(window).width() < 540 ){
            //							view.calendar.el.find('.fc-right').find('.btn-group').removeClass('btn-group').addClass('btn-group-vertical');
            //						}
            //					}
            //                "
            //                            ),*/
            //                            /*'viewRender' => new JsExpression(
            //                                "function (view,event, element){
            //								localStorage.setItem('fcDefaultView', view.name);
            //								var date = $('#calendar').fullCalendar('getDate');
            //								localStorage.setItem('fcDefaultViewDate', date.format());
            //                	}"
            //                            ),*/
            //                        ],
            //
            //                    ]
            //                ); ?>

        </div>
    </div>
</div>