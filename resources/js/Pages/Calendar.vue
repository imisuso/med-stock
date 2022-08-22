<template>
    <AppLayout>
        <div>
            <FullCalendar :events="events" :options="calendarOptions"/>
        </div>
    </AppLayout>
</template>

<script>
import { ref, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
//import '@fullcalendar/core/vdom' // solves problem with Vite
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction'
import thLocale from '@fullcalendar/core/locales/th';
import EventService from '@/Services/EventService';

export default {
    components: {
        AppLayout,
    },
    setup() {
        // onMounted(() => {
        //     eventService.value.getEvents().then(data => {
        //         events.value = data;
        //         // console.log(data);
        //         // console.log(eventService.value.getEvents());
        //         // console.log(events.value);
        //     });
        // })

        const calendarOptions =  ref({
            plugins:[dayGridPlugin, timeGridPlugin, interactionPlugin],
            locale: thLocale,
            //initialDate : '2021-08-01',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            //editable: true,
            //selectable:true, 
            //selectMirror: true,
            // events: [
            //     {"id": 1,"title": "All Day Event","start": "2021-08-01"},
            //     {"id": 2,"title": "Long Event","start": "2021-08-07","end": "2021-08-10"},
            //     {"id": 3,"title": "Repeating Event","start": "2021-08-09T16:00:00"},
            //     {"id": 4,"title": "Repeating Event","start": "2021-08-16T16:00:00"},
            //     {"id": 5,"title": "Conference","start": "2021-08-11","end": "2021-08-13"},
            //     {"id": 6,"title": "Meeting","start": "2021-08-12T10:30:00","end": "2021-08-12T12:37:00"},
            //     {"id": 7,"title": "Lunch","start": "2021-08-12T12:00:00"},
            //     {"id": 8,"title": "Meeting","start": "2021-08-12T14:30:00"},
            //     {"id": 9,"title": "Happy Hour","start": "2021-08-12T17:30:00"},
            //     {"id": 10,"title": "Dinner","start": "2021-08-12T20:00:00"},
            //     {"id": 11,"title": "Birthday Party","start": "2021-08-13T07:00:00"},
            //     {"id": 12,"title": "Click for Google","url": "https://www.google.com/","start": "2021-08-28"}
            // ], 
            dayMaxEvents: true,
            //dateClick: this.handleDateClick,
            dateClick: function(info) {
                alert('Clicked on: ' + info.dateStr);
                // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                // alert('Current view: ' + info.view.type);
                // Comment change the day's background color just for fun
                //info.dayEl.style.backgroundColor = 'red';
            },
            eventClick: function(info) {
                alert('Event: ' + info.event.title);
                //alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                //alert('View: ' + info.view.type);

                // change the border color just for fun
                //info.el.style.borderColor = 'red';
            }
        });
        const events =  ref(null);
        const eventService = ref(new EventService());
        return { calendarOptions, events, eventService };
    },
}
</script>

<style scoped>
@media screen and (max-width: 960px) {
    ::v-deep(.fc-header-toolbar) {
        display: flex;
        flex-wrap: wrap;
    }
}
</style>