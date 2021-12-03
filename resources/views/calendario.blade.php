@extends('welcome')

@section('content')
<h3>Horario</h3>
<br>
<div id="calendar"></div>
<script>
    $(document).ready(function () {
        var calendar = $('#calendar').fullCalendar({
            editable:true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            events:'/calendario',
            selectable:true,
            selectHelper:true,
            select: function(start,end,allDay){
                var titulo = prompt('Event Title:');
                if(titulo){
                   var inicio = $.fullCalendar.formatDate(start,'Y-MM-DD HH:mm:ss');
                   var fin = $.fullCalendar.formatDate(end,'Y-MM-DD HH:mm:ss');
                   $.ajax({
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        },
                        url:"/calendario/action",
                       type:"POST",
                       data:{
                           titulo:titulo,
                           inicio:inicio,
                           fin:fin,
                           tipo:'add'
                       },
                       success:function(data){
                           calendar.fullCalendar('refetchEvents');
                           alert("Evento Creado");
                       }
                   });
                }
            },
            eventResize:function(event,delta){
                var inicio = $.fullCalendar.formatDate(start,'Y-MM-DD HH:mm:ss');
                var fin =$.fullCalendar.formatDate(end,'Y-MM-DD HH:mm:ss');
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url:"calendario/action",
                    type:"POST",
                    data:{
                        titulo:title,
                        inicio:inicio,
                        fin:fin,
                        id:id,
                        tipo:'update'
                    },
                    success:function(response){
                        calendar.fullCalendar('refetchEvents');
                        alert("Evento Actualizado");
                    }
                });
            }
        });
    });
</script>
@endsection
