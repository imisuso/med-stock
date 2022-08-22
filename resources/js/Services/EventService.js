import axios from 'axios';

export default class EventService {

    getEvents() {
        return axios.get('/storage/data/events.json').then(res => res.data.data);
    }
}